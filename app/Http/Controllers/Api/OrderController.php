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
    // Customer: place a new order
    public function store(Request $request)
    {
        $validated = $request->validate([
            'farmer_profile_id' => 'required|exists:farmer_profiles,id',
            'pickup_date'       => 'required|date|after_or_equal:today',
            'pickup_time'       => 'required|date_format:H:i',
            'note'              => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.product_id'=> 'required|exists:products,id',
            'items.*.quantity'  => 'required|integer|min:1',
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
                $product = Product::findOrFail($item['product_id']);

                if ($product->farmer_profile_id !== $order->farmer_profile_id) {
                    throw new \Exception('All products must be from the same farmer.');
                }
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->name}.");
                }

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'price'      => $product->price,
                ]);

                $total += $product->price * $item['quantity'];
            }

            $order->update(['total_amount' => $total]);

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Order placed successfully',
                'data'    => $order->load('items.product'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Customer: my orders
    public function myOrders(Request $request)
    {
        return response()->json([
            'status' => true,
            'data'   => Order::with(['items.product', 'farmer'])
                             ->where('customer_id', $request->user()->id)
                             ->latest()
                             ->paginate(20),
        ]);
    }

    // Customer: cancel order
    public function cancel(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }
        if (! in_array($order->status, ['placed', 'accepted'])) {
            return response()->json([
                'status'  => false,
                'message' => 'Order cannot be cancelled at this stage.',
            ], 422);
        }

        $order->update(['status' => 'cancelled']);

        return response()->json([
            'status'  => true,
            'message' => 'Order cancelled',
        ]);
    }

    public function showOwn(Request $request, Order $order)
    {
        if ($order->customer_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json([
            'status' => true,
            'data'   => $order->load(['items.product', 'farmer.user']),
        ]);
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

        $orders        = $query->latest()->paginate(30);
        $totalRevenue  = Order::where('status', 'completed')->sum('total_amount');
        $totalOrders   = Order::count();
        $statusCounts  = Order::selectRaw('status, count(*) as count')->groupBy('status')->pluck('count', 'status');

        return response()->json([
            'status'        => true,
            'data'          => $orders,
            'summary'       => [
                'total_orders'   => $totalOrders,
                'total_revenue'  => $totalRevenue,
                'status_counts'  => $statusCounts,
            ],
        ]);
    }
}