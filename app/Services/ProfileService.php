<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class ProfileService
{
    protected $profileRepository;
    
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
    
    public function updateProfile(User $user, array $attributes): User
    {
        if (!Gate::allows('manage_profile')) {
            throw new \Exception('Vous n\'avez pas la permission de modifier ce profil.');
        }
        
    
        $user = $this->profileRepository->updateProfile($user, $attributes);
        
       
        if (isset($attributes['profile_image']) && $attributes['profile_image'] instanceof UploadedFile) {
            Log::info('Sauvegarde de l\'image de profil pour l\'utilisateur: ' . $user->id);
            $this->profileRepository->saveProfileImage($user, $attributes['profile_image']);
        }
        
        return $user;
    }
    
    public function deleteProfileImage(User $user): void
    {
        if (!Gate::allows('manage_profile')) {
            throw new \Exception('Vous n\'avez pas la permission de supprimer cette image.');
        }
        
        $this->profileRepository->deleteProfileImage($user);
    }
}