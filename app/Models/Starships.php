<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Starships extends Model
{
    protected $fillable = [
        'name', 'model', 'starship_class', 'manufacturer', 'cost_in_credits', 'length', 'crew', 'passengers',
        'max_atmosphering_speed', 'hyperdrive_rating', 'MGLT', 'cargo_capacity', 'consumables',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_starships');
    }

    public function pilots()
    {
        return $this->belongsToMany(People::class, 'people_starships');
    }}
