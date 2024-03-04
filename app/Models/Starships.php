<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starships extends Model
{
    protected $fillable = [
        'model', 'starship_class','hyperdrive_rating', 'MGLT',
    ];

    public function films()
    {
        return $this->belongsToMany(Films::class, 'film_starships', 'starship_id', 'film_id');
    }

    public function pilots()
    {
        return $this->belongsToMany(People::class, 'people_starships', 'starship_id', 'people_id');
    }
    public function getUrlAttribute()
    {
        return url("/starships/{$this->id}");
    }
}
