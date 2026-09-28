<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'farmer_profile_id', 'category_id', 'market_id', 'name', 'description',
        'price', 'unit', 'image_path', 'stock_quantity', 'status',
    ];

    public function farmer()   { return $this->belongsTo(FarmerProfile::class, 'farmer_profile_id'); }
    public function category() { return $this->belongsTo(Category::class); }
    public function market()   { return $this->belongsTo(Market::class); }
    public function orderItems(){ return $this->hasMany(OrderItem::class); }
    public function reviews()  { return $this->hasMany(Review::class); }
}