<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->role->name === 'Gérant' && !$user->is_approved) {
                Auth::logout();
                return redirect()->back()
                    ->with('error', 'Votre compte est en attente d\'approbation.');
            }
            
            switch ($user->role->name) {
                case 'Administrateur':
                    return redirect()->route('admin.dashboard');
                case 'Gérant':
                    return redirect()->route('gerant.dashboard');
                case 'Client':
                default:
                    return redirect()->route('home'); 
            }
        }
        
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Ces identifiants ne correspondent pas à nos enregistrements.');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}