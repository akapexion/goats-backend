<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $fillable = [
        'name', 'address', 'city', 'latitude', 'longitude',
        'open_days', 'open_time', 'close_time', 'is_active',
    ];

    public function farmers() { return $this->hasMany(FarmerProfile::class); }
}