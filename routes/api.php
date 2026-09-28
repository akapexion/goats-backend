<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FarmerProfileController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\Admin\UserController as AdminUserController;
use App\Http\Controllers\Api\Farmer\DashboardController as FarmerDashboard;
use App\Http\Controllers\Api\Farmer\IncomingOrderController;
use App\Http\Controllers\Api\Customer\DashboardController as CustomerDashboard;

use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


Route::get('/markets',         [MarketController::class, 'index']);
Route::get('/markets/{market}', [MarketController::class, 'show']);
Route::get('/categories',      [CategoryController::class, 'index']);
Route::get('/farmers',         [FarmerProfileController::class, 'index']);
Route::get('/farmers/{farmer}', [FarmerProfileController::class, 'show']);
Route::get('/products',        [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);


Route::get('/farmers/{farmer}/reviews', [ReviewController::class, 'farmerReviews']);
Route::get('/products/{product}/reviews', [ReviewController::class, 'productReviews']);


Route::middleware('auth:sanctum')->group(function () {

   
    Route::get('/me',      [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    
    Route::get('/notifications',              [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read',   [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all',    [NotificationController::class, 'markAllAsRead']);

   
    Route::middleware('role:admin')->prefix('admin')->group(function () {

       
        Route::get('/dashboard', fn () => response()->json([
            'message' => 'Admin dashboard',
            'stats'   => [
                'total_users'    => \App\Models\User::count(),
                'total_farmers'  => \App\Models\User::where('role', 'farmer')->count(),
                'total_customers'=> \App\Models\User::where('role', 'customer')->count(),
                'total_markets'  => \App\Models\Market::count(),
                'total_orders'   => \App\Models\Order::count(),
            ],
        ]));

        
        Route::get('/users',                    [AdminUserController::class, 'index']);
        Route::post('/users',                   [AdminUserController::class, 'store']);
        Route::get('/users/{user}',             [AdminUserController::class, 'show']);
        Route::put('/users/{user}',             [AdminUserController::class, 'update']);
        Route::delete('/users/{user}',          [AdminUserController::class, 'destroy']);
        Route::patch('/users/{user}/status',    [AdminUserController::class, 'toggleStatus']);

       
        Route::get('/farmers/pending',          [FarmerProfileController::class, 'pending']);
        Route::patch('/farmers/{farmer}/approve', [FarmerProfileController::class, 'approve']);
        Route::patch('/farmers/{farmer}/suspend', [FarmerProfileController::class, 'suspend']);

       
        Route::post('/markets',                 [MarketController::class, 'store']);
        Route::put('/markets/{market}',         [MarketController::class, 'update']);
        Route::delete('/markets/{market}',      [MarketController::class, 'destroy']);

       
        Route::post('/categories',              [CategoryController::class, 'store']);
        Route::put('/categories/{category}',    [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

       
        Route::get('/reviews',                  [ReviewController::class, 'adminIndex']);
        Route::delete('/reviews/{review}',      [ReviewController::class, 'adminDestroy']);
        Route::get('/products/all',             [ProductController::class, 'adminIndex']);
        Route::delete('/products/{product}',    [ProductController::class, 'adminDestroy']);

        
        Route::get('/reports/orders',           [OrderController::class, 'adminReport']);
    });

    // farmer routes
    Route::middleware('role:farmer')->prefix('farmer')->group(function () {

       
        Route::get('/dashboard', [FarmerDashboard::class, 'index']);

       
        Route::get('/profile',      [FarmerProfileController::class, 'myProfile']);
        Route::put('/profile',      [FarmerProfileController::class, 'updateMyProfile']);

      
        Route::get('/products',              [ProductController::class, 'myProducts']);
        Route::post('/products',             [ProductController::class, 'store']);
        Route::get('/products/{product}',    [ProductController::class, 'showOwn']);
        Route::put('/products/{product}',    [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
        Route::patch('/products/{product}/status', [ProductController::class, 'updateStatus']);

        
        Route::get('/orders',                     [IncomingOrderController::class, 'index']);
        Route::get('/orders/{order}',             [IncomingOrderController::class, 'show']);
        Route::patch('/orders/{order}/accept',    [IncomingOrderController::class, 'accept']);
        Route::patch('/orders/{order}/decline',   [IncomingOrderController::class, 'decline']);
        Route::patch('/orders/{order}/ready',     [IncomingOrderController::class, 'markReady']);
        Route::patch('/orders/{order}/complete',  [IncomingOrderController::class, 'markCompleted']);

        
        Route::get('/reviews',                    [ReviewController::class, 'farmerIndex']);
        Route::post('/reviews/{review}/reply',    [ReviewController::class, 'reply']);
    });


    // customer routes
    Route::middleware('role:customer')->prefix('customer')->group(function () {

        Route::get('/dashboard', [CustomerDashboard::class, 'index']);

        Route::get('/orders',                 [OrderController::class, 'myOrders']);
        Route::post('/orders',                [OrderController::class, 'store']);
        Route::get('/orders/{order}',         [OrderController::class, 'showOwn']);
        Route::put('/orders/{order}',         [OrderController::class, 'update']);
        Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel']);
        Route::post('/orders/{order}/reorder', [OrderController::class, 'reorder']);

        Route::get('/favorites',              [FavoriteController::class, 'index']);
        Route::get('/favorites/check',        [FavoriteController::class, 'check']);
        Route::post('/favorites',             [FavoriteController::class, 'store']);
        Route::delete('/favorites/{id}',      [FavoriteController::class, 'destroy']);

        Route::post('/reviews',               [ReviewController::class, 'store']);
        Route::put('/reviews/{review}',       [ReviewController::class, 'update']);
        Route::delete('/reviews/{review}',    [ReviewController::class, 'destroy']);
    });
});