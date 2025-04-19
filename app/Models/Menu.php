<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    
    protected $fillable = ['type', 'restaurant_id'];
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }
}