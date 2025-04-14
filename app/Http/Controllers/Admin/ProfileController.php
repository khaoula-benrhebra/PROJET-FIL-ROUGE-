<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;
    
    public function __construct(ProfileService $profileService)
    {
        $this->middleware('auth');
        $this->middleware('role:Administrateur');
        $this->profileService = $profileService;
    }
    
    public function index()
    {
        $user = Auth::user();
        return view('pages.admin.profile', compact('user'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('pages.admin.profile_edit', compact('user'));
    }
    
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        try {
            $this->profileService->updateProfile($user, $request->validated());
            return redirect()->route('admin.profile')->with('success', 'Profil mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    public function deleteImage()
    {
        $user = Auth::user();
        
        try {
            $this->profileService->deleteProfileImage($user);
            return redirect()->back()->with('success', 'Image de profil supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}