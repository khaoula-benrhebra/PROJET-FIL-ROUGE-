<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasFactory, Notifiable, HasApiTokens, InteractsWithMedia;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'is_approved'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function hasPermission($permission)
    {
        return $this->role->permissions()->where('id', $permission)->exists();
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')
            ->singleFile();
    }

    public function reservations()
{
    return $this->hasMany(Reservation::class);
}
}