<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    protected $fillable = [
        'vehicle_class',
        'id_transport',
    ];

    public function films()
    {
        return $this->belongsToMany(Films::class, 'film_vehicles', 'vehicle_id', 'film_id');
    }

    public function pilots()
    {
        return $this->belongsToMany(People::class, 'people_vehicles', 'vehicle_id', 'people_id');
    }
    public function getUrlAttribute()
    {
        return url("/vehicles/{$this->id}");
    }
}
