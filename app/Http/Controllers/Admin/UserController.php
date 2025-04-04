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
    
    // public function index()
    // {
    //     $pendingManagers = $this->userService->getPendingManagers();
    //     return view('pages.admin.dashboard', compact('pendingManagers')); // Assurez-vous que c'est la bonne vue
    // }

    public function index()
{
    $pendingManagers = $this->userService->getPendingManagers();
    $allManagers = $this->userService->getAllManagers();
    return view('pages.admin.dashboard', compact('pendingManagers', 'allManagers'));
}
    
    public function approve($id)
    {
        $this->userService->approveManager($id);
        return redirect()->back()->with('success', 'Gérant approuvé avec succès.');
    }
    
    public function delete($id)
    {
        try {
            $this->userService->deleteUser($id);
            return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'utilisateur.');
        }
    }
}