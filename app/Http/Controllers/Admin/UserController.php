<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $categoryService;
    
    public function __construct(UserService $userService, CategoryService $categoryService)
    {
        $this->middleware('role:Administrateur');
        $this->userService = $userService;
        $this->categoryService = $categoryService;
    }
    
    public function index()
    {
        $pendingManagers = $this->userService->getPendingManagers();
        $allManagers = $this->userService->getAllManagers();
        $categories = $this->categoryService->getAllCategories();
        return view('pages.admin.dashboard', compact('pendingManagers', 'allManagers', 'categories'));
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