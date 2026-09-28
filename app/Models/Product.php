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

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        $path = $this->image_path;
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, 'data:')) {
            return $path;
        }

        $cleanPath = ltrim($path, '/');
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }

        return url('storage/' . $cleanPath);
    }

    public function farmer()
    {
        return $this->belongsTo(FarmerProfile::class, 'farmer_profile_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}