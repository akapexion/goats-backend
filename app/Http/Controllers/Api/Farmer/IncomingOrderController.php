<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class IncomingOrderController extends Controller
{
    public function index(Request $request)
    {
        $farmer = $request->user()->farmerProfile;

        if (!$farmer) {
            return response()->json(['status' => false, 'message' => 'Farmer profile not found.'], 404);
        }

        $query = Order::with(['customer', 'items.product'])
            ->where('farmer_profile_id', $farmer->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return response()->json([
            'status' => true,
            'data'   => $query->latest()->paginate(20),
        ]);
    }

    public function show(Request $request, Order $order)
    {
        $farmer = $request->user()->farmerProfile;

        if ($order->farmer_profile_id !== $farmer->id) {
            abort(403);
        }

        return response()->json([
            'status' => true,
            'data'   => $order->load(['customer', 'items.product']),
        ]);
    }

    public function accept(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'placed') {
            return response()->json(['status' => false, 'message' => 'Only placed orders can be accepted.'], 422);
        }

        $order->update(['status' => 'accepted']);

        return response()->json(['status' => true, 'message' => 'Order accepted', 'data' => $order]);
    }

    public function decline(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'placed') {
            return response()->json(['status' => false, 'message' => 'Only placed orders can be declined.'], 422);
        }

        $order->update(['status' => 'declined']);

        return response()->json(['status' => true, 'message' => 'Order declined', 'data' => $order]);
    }

    public function markReady(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'accepted') {
            return response()->json(['status' => false, 'message' => 'Order must be accepted first.'], 422);
        }

        $order->update(['status' => 'ready']);

        return response()->json(['status' => true, 'message' => 'Order marked as ready', 'data' => $order]);
    }

    public function markCompleted(Request $request, Order $order)
    {
        $this->authorizeOrder($request, $order);

        if ($order->status !== 'ready') {
            return response()->json(['status' => false, 'message' => 'Order must be ready before completing.'], 422);
        }

        $order->update(['status' => 'completed']);

        return response()->json(['status' => true, 'message' => 'Order completed', 'data' => $order]);
    }

    private function authorizeOrder(Request $request, Order $order)
    {
        $farmer = $request->user()->farmerProfile;

        if (!$farmer || $order->farmer_profile_id !== $farmer->id) {
            abort(403);
        }
    }
}
