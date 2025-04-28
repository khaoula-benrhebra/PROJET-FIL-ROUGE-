<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\ReviewService;
use App\Services\RestaurantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    protected $reviewService;
    protected $restaurantService;
    
    public function __construct(
        ReviewService $reviewService,
        RestaurantService $restaurantService
    ) {
        $this->middleware('auth');
        $this->reviewService = $reviewService;
        $this->restaurantService = $restaurantService;
    }
    
 
    
    public function create(Request $request)
    {
        $restaurantId = $request->input('restaurant_id');
        
        if (!$restaurantId) {
            return redirect()->route('restaurants')
                ->with('error', 'Veuillez sélectionner un restaurant pour laisser un avis.');
        }
        
        $restaurant = $this->restaurantService->getRestaurantById($restaurantId);
        
        if (!$restaurant) {
            return redirect()->route('restaurants')
                ->with('error', 'Restaurant non trouvé.');
        }
        
        if (!$this->reviewService->canReviewRestaurant($restaurantId)) {
            return redirect()->route('restaurant.show', $restaurantId)
                ->with('error', 'Vous devez avoir réservé dans ce restaurant pour pouvoir laisser un avis.');
        }
        
        return view('pages.client.review_create', compact('restaurant'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ], [
            'restaurant_id.required' => 'L\'identifiant du restaurant est requis.',
            'restaurant_id.exists' => 'Le restaurant sélectionné n\'existe pas.',
            'rating.required' => 'La note est requise.',
            'rating.integer' => 'La note doit être un nombre entier.',
            'rating.min' => 'La note minimale est de 1.',
            'rating.max' => 'La note maximale est de 5.',
            'comment.required' => 'Le commentaire est requis.',
            'comment.max' => 'Le commentaire ne doit pas dépasser 500 caractères.',
        ]);
        
        try {
            $this->reviewService->createReview($validated);
            
            return redirect()->route('restaurant.show', $validated['restaurant_id'])
                ->with('success', 'Votre avis a été publié avec succès.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }
}