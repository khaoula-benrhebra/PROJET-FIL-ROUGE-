<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    
    public function __construct(CategoryService $categoryService)
    {
        $this->middleware('auth');
        $this->middleware('role:Administrateur');
        $this->categoryService = $categoryService;
    }
    
    public function index()
    {
        $categories = $this->categoryService->getAllCategories();
        return view('pages.admin.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('pages.admin.categories.create');
    }
    
    public function store(CreateCategoryRequest $request)
    {
        try {
            $this->categoryService->createCategory($request->validated());
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('pages.admin.categories.edit', compact('category'));
    }
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $this->categoryService->updateCategory($id, $request->validated());
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
    public function destroy($id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            if (!$category) {
                return redirect()->route('admin.categories.index')->with('error', 'Catégorie introuvable');
            }
            
            $this->categoryService->deleteCategory($id);
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', $e->getMessage());
        }
    }
    
  
}