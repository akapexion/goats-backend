<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmerProfile extends Model
{
    protected $fillable = [
        'user_id', 'market_id', 'stall_name', 'description', 'address',
        'latitude', 'longitude', 'operating_days',
        'pickup_start_time', 'pickup_end_time', 'cutoff_hours',
        'approval_status',
    ];

    public function user()    { return $this->belongsTo(User::class); }
    public function market()  { return $this->belongsTo(Market::class); }
    public function products(){ return $this->hasMany(Product::class); }
    public function orders()  { return $this->hasMany(Order::class); }
    public function reviews() { return $this->hasMany(Review::class); }
}