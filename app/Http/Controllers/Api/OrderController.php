<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farmer_profile_id'  => 'required|exists:farmer_profiles,id',
            'pickup_date'        => 'required|date|after_or_equal:today',
            'pickup_time'        => 'required',
            'note'               => 'nullable|string',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id'       => $request->user()->id,
                'farmer_profile_id' => $validated['farmer_profile_id'],
                'pickup_date'       => $validated['pickup_date'],
                'pickup_time'       => $validated['pickup_time'],
                'note'              => $validated['note'] ?? null,
                'status'            => 'placed',
                'total_amount'      => 0,
            ]);

            $total = 0;
            foreach ($validated['items'] as $item) {
                $product = Product::where('id', $item['product_id'])->lockForUpdate()->firstOrFail();

                if ($product->farmer_profile_id !== $order->farmer_profile_id) {
                    throw new \Exception("Product {$product->name} does not belong to the selected farmer.");
                }

                if ($product->status !== 'available') {
                    throw new \Exception("Product {$product->name} is currently unavailable.");
                }

                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available stock: {$product->stock_quantity} {$product->unit}.");
                }

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);

                $total += $product->price * $item['quantity'];
            }

            $order->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Pre-order placed successfully',
                'data'    => $order->load(['items.product', 'farmer.market', 'farmer.user']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function myOrders(Request $request)
    {
        return response()->json([
            'status' => true,
            'data'   => Order::with(['items.product', 'farmer.user', 'farmer.market'])
                             ->where('customer_id', $request->user()->id)
                             ->latest()
                             ->paginate(20),
        ]);
    }

    public function showOwn(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json([
            'status' => true,
            'data'   => $order->load(['items.product', 'farmer.user', 'farmer.market']),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        if (!in_array($order->status, ['placed', 'accepted'])) {
            return response()->json([
                'status'  => false,
                'message' => 'Order cannot be modified at its current status.',
            ], 422);
        }

        $validated = $request->validate([
            'pickup_date'        => 'sometimes|date|after_or_equal:today',
            'pickup_time'        => 'sometimes',
            'note'               => 'nullable|string',
            'items'              => 'sometimes|array|min:1',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity'   => 'required_with:items|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            if (isset($validated['items'])) {
                foreach ($order->items as $oldItem) {
                    Product::where('id', $oldItem->product_id)->increment('stock_quantity', $oldItem->quantity);
                }

                $order->items()->delete();

                $total = 0;
                foreach ($validated['items'] as $item) {
                    $product = Product::where('id', $item['product_id'])->lockForUpdate()->firstOrFail();

                    if ($product->farmer_profile_id !== $order->farmer_profile_id) {
                        throw new \Exception("Product {$product->name} does not belong to the order farmer.");
                    }

                    if ($product->status !== 'available') {
                        throw new \Exception("Product {$product->name} is unavailable.");
                    }

                    if ($product->stock_quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$product->name}. Only {$product->stock_quantity} left.");
                    }

                    OrderItem::create([
                        'order_id'   => $order->id,
                        'product_id' => $product->id,
                        'quantity'   => $item['quantity'],
                        'price'      => $product->price,
                    ]);

                    $product->decrement('stock_quantity', $item['quantity']);
                    $total += $product->price * $item['quantity'];
                }

                $validated['total_amount'] = $total;
            }

            unset($validated['items']);
            $order->update($validated);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Order updated successfully',
                'data'    => $order->load(['items.product', 'farmer.user', 'farmer.market']),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function cancel(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        if (!in_array($order->status, ['placed', 'accepted'])) {
            return response()->json([
                'status'  => false,
                'message' => 'Order cannot be cancelled at this stage.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($order->items as $item) {
                Product::where('id', $item->product_id)->increment('stock_quantity', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Order cancelled and reserved stock restored.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Failed to cancel order.',
            ], 500);
        }
    }

    public function reorder(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            $order->load('items.product');
            $newItems = [];

            foreach ($order->items as $oldItem) {
                $product = Product::where('id', $oldItem->product_id)->lockForUpdate()->first();

                if (!$product || $product->status !== 'available') {
                    throw new \Exception("Product '{$oldItem->product?->name}' is no longer available.");
                }

                if ($product->stock_quantity < $oldItem->quantity) {
                    throw new \Exception("Insufficient stock to re-order '{$product->name}'. Available: {$product->stock_quantity}.");
                }

                $newItems[] = [
                    'product'  => $product,
                    'quantity' => $oldItem->quantity,
                ];
            }

            $newOrder = Order::create([
                'customer_id'       => $request->user()->id,
                'farmer_profile_id' => $order->farmer_profile_id,
                'pickup_date'       => now()->addDay()->toDateString(),
                'pickup_time'       => $order->pickup_time ?: '10:00',
                'note'              => 'Re-order of Order #' . $order->id,
                'status'            => 'placed',
                'total_amount'      => 0,
            ]);

            $total = 0;
            foreach ($newItems as $item) {
                $product = $item['product'];
                $qty     = $item['quantity'];

                OrderItem::create([
                    'order_id'   => $newOrder->id,
                    'product_id' => $product->id,
                    'quantity'   => $qty,
                    'price'      => $product->price,
                ]);

                $product->decrement('stock_quantity', $qty);
                $total += $product->price * $qty;
            }

            $newOrder->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Re-ordered successfully!',
                'data'    => $newOrder->load(['items.product', 'farmer.user']),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function adminReport(Request $request)
    {
        $query = Order::with(['customer', 'farmer.user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $orders       = $query->latest()->paginate(30);
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders  = Order::count();
        $statusCounts = Order::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');

        return response()->json([
            'status'  => true,
            'data'    => $orders,
            'summary' => [
                'total_orders'  => $totalOrders,
                'total_revenue' => $totalRevenue,
                'status_counts' => $statusCounts,
            ],
        ]);
    }
}