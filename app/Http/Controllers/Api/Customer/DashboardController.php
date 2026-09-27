<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Favorite;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $totalOrders     = Order::where('customer_id', $user->id)->count();
        $pendingOrders   = Order::where('customer_id', $user->id)
            ->whereIn('status', ['placed', 'accepted'])
            ->count();
        $completedOrders = Order::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->count();
        $totalSpent      = Order::where('customer_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_amount');
        $favoritesCount  = Favorite::where('user_id', $user->id)->count();

        $recentOrders = Order::with(['farmer', 'items.product'])
            ->where('customer_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'stats'  => [
                'total_orders'     => $totalOrders,
                'pending_orders'   => $pendingOrders,
                'completed_orders' => $completedOrders,
                'total_spent'      => $totalSpent,
                'favorites_count'  => $favoritesCount,
            ],
            'recent_orders' => $recentOrders,
        ]);
    }
}
