<?php

namespace App\Http\Controllers\Api\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $farmer = $request->user()->farmerProfile;

        if (!$farmer) {
            return response()->json([
                'status'  => false,
                'message' => 'Farmer profile not found. Please complete your profile first.',
            ], 404);
        }

        $totalOrders   = Order::where('farmer_profile_id', $farmer->id)->count();
        $pendingOrders = Order::where('farmer_profile_id', $farmer->id)
            ->whereIn('status', ['placed', 'accepted'])
            ->count();
        $totalRevenue  = Order::where('farmer_profile_id', $farmer->id)
            ->where('status', 'completed')
            ->sum('total_amount');
        $totalProducts = Product::where('farmer_profile_id', $farmer->id)->count();

        $recentOrders = Order::with(['customer', 'items.product'])
            ->where('farmer_profile_id', $farmer->id)
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::where('farmer_profile_id', $farmer->id)
            ->withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'stats'  => [
                'total_orders'    => $totalOrders,
                'pending_orders'  => $pendingOrders,
                'total_revenue'   => $totalRevenue,
                'total_products'  => $totalProducts,
            ],
            'recent_orders' => $recentOrders,
            'top_products'  => $topProducts,
            'approval_status' => $farmer->approval_status,
        ]);
    }
}
