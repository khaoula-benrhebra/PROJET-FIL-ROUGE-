<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Meal extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    protected $fillable = ['name', 'description', 'price', 'menu_id'];
    
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('meal')
            ->singleFile();
    }

    public function reservations()
{
    return $this->belongsToMany(Reservation::class)
        ->withPivot('quantity', 'unit_price')
        ->withTimestamps();
}
}