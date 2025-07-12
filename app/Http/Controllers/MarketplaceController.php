<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Weapon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MarketplaceController extends Controller
{
    public function index(): View
    {
        // Query 1: Get all featured weapons.
        $featuredWeapons = Weapon::with('category', 'country')
            ->where('is_featured', true)
            ->orderByDesc('created_at')
            ->get();
            // ->paginate(8);

        // Query 2: Get a paginated list of all non-featured weapons.
        $weapons = Weapon::with('category', 'country')
            ->where('is_featured', false)
            ->orderByDesc('created_at')
            ->get();
            // ->paginate(12); // Shows 12 weapons per page

        // Query 3: Get all categories for the filter sidebar.
        $categories = Category::all();

        // Pass all the data to the view.
        return view('marketplace', [
            'featuredWeapons' => $featuredWeapons,
            'weapons' => $weapons,
            'categories' => $categories,
        ]);
    }


    public function showByCategory(Category $category)
    {
        $featuredWeapons = Weapon::with('category', 'country')
            ->where('is_featured', true)
            ->where('category_id', $category->id)
            ->orderByDesc('created_at')
            ->paginate(8); // Shows 8 featured weapons per page
        $weapons = Weapon::where('category_id', $category->id)
            ->where('is_featured', false)
            ->with('country')
            ->paginate(12); // Paginate the weapons in the chosen category
        $categories = Category::all();
        $categoryChosen = $category;
        $user = Auth::user();

        return view('marketplace', [
            'featuredWeapons' => $featuredWeapons,
            'weapons' => $weapons,
            'categories' => $categories,
            'user' => $user,
            'categoryChosen' => $categoryChosen,
        ]);
    }


}
