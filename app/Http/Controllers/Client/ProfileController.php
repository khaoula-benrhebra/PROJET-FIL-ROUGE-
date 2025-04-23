<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;
    protected $reservationService;
    
    public function __construct(ProfileService $profileService, ReservationService $reservationService)
    {
        $this->middleware('auth');
        $this->profileService = $profileService;
        $this->reservationService = $reservationService;
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Si l'utilisateur est un client, récupérer ses réservations
        $reservations = [];
        if ($user->role->name === 'Client') {
            $reservations = $this->reservationService->getReservationsByUser();
        }

        return view('pages.client.profile', compact('user', 'reservations'));
    }
    
    public function edit()
    {
        $user = Auth::user();
        return view('pages.client.profile_edit', compact('user'));
    }
    
    public function update(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        try {
            $this->profileService->updateProfile($user, $request->validated());
            return redirect()->route('client.profile')->with('success', 'Profil mis à jour avec succès.');
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