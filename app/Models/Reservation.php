<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'name',
        'email',
        'phone',
        'guests',
        'reservation_datetime',
        'special_requests',
        'total_amount',
        'status'
    ];
    
    protected $casts = [
        'reservation_datetime' => 'datetime',
        'guests' => 'integer',
        'total_amount' => 'decimal:2'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    
    public function meals()
    {
        return $this->belongsToMany(Meal::class)
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }
    
    public function tables()
    {
         return $this->belongsToMany(Table::class)
            ->withTimestamps();
    }
    
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }
}