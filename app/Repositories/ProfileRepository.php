<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\UploadedFile;

class ProfileRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    
    public function updateProfile(User $user, array $attributes): User
    {
        $user->update([
            'name' => $attributes['name'],
            'email' => $attributes['email']
        ]);
        
        return $user;
    }
    
    public function saveProfileImage(User $user, UploadedFile $image): void
    {
       
        $user->clearMediaCollection('profile');
        
        
        $user->addMedia($image)
             ->toMediaCollection('profile', 'public');
    }
    
    public function deleteProfileImage(User $user): void
    {
        $user->clearMediaCollection('profile');
    }
}