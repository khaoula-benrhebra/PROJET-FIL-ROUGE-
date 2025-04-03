<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function showRegistrationForm()
    {
        return view('pages.register');
    }
    
    public function register(RegisterRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        
        // dd( $user);
        // exit;
        if ($request->role === 'restaurant_manager') {
            return redirect()->route('pages.login')
                ->with('info', 'Votre compte est en attente d\'approbation par un administrateur.');
        }
        
        
        Auth::login($user);
        return redirect('/');
    }

}