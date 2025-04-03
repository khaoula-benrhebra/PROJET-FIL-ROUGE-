<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    protected $fillable = ['id', 'name'];
    
    protected $keyType = 'string';
    public $incrementing = false;
    
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}