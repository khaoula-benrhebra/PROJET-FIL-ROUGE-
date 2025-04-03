<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthGates 
{
    /**
     * Handle an incoming request.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user) {
            $roles = Role::with('permissions')->get();
            $permissionsArray = [];
            
            foreach ($roles as $role) {
                foreach ($role->permissions as $permission) {
                    $permissionsArray[$permission->id][] = $role->id;
                }
            }
            
            foreach ($permissionsArray as $id => $roles) {
                Gate::define($id, function (User $user) use ($roles) {
                    return in_array($user->role_id, $roles);
                });
            }
        }
        
        return $next($request);
    }
}