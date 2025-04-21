<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    
    protected $fillable = ['restaurant_id', 'table_label', 'is_available'];
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations()
{
    return $this->belongsToMany(Reservation::class)
        ->withTimestamps();
}
}