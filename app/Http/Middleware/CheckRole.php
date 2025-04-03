<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }
        
        $user = Auth::user();
        
        
        if ($user->role->name === 'Gérant' && !$user->is_approved) {
            Auth::logout();
            return redirect('login')->with('error', 'Votre compte est en attente d\'approbation.');
        }
        
        if ($user->role->name !== $role) {
            return redirect('/')->with('error', 'Vous n\'avez pas les permissions nécessaires.');
        }
        
        return $next($request);
    }
}