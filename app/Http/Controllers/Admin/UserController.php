<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    
    public function __construct(UserService $userService)
    {
        $this->middleware('role:Administrateur');
        $this->userService = $userService;
    }
    
    public function index()
    {
        $pendingManagers = $this->userService->getPendingManagers();
        return view('admin.users.index', compact('pendingManagers'));
    }
    
    public function approve($id)
    {
        $this->userService->approveManager($id);
        return redirect()->back()->with('success', 'Gérant approuvé avec succès.');
    }
    
    public function delete($id)
    {
        
        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }

}