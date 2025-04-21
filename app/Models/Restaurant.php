<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Restaurant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    
    protected $fillable = ['name', 'address', 'description', 'user_id' , 'number_of_tables', 'seats_per_table'];
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('restaurant')
            ->singleFile();
    }

    public function menus()
{
    return $this->hasMany(Menu::class);
}

public function tables()
{
    return $this->hasMany(Table::class);
}

public function reservations()
{
    return $this->hasMany(Reservation::class);
}
}