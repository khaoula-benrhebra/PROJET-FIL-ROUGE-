<?php

namespace App\Http\Controllers\Gerant;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    protected $categoryRepository;
    
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('auth');
        $this->middleware('role:Gérant');
        $this->categoryRepository = $categoryRepository;
    }
    
    public function index()
    {
        $categories = $this->categoryRepository->getAllSorted();
        return view('pages.gerant.restaurant', compact('categories'));
    }
}