<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Http\Requests\StoreWeaponRequest;
use App\Http\Requests\UpdateWeaponRequest;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;

class WeaponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $weapons = Weapon::with('category')->orderByDesc('created_at')->get();
        $categories = Category::all();
        $user = Auth::user();
        return view('marketplace', [
            'weapons' => $weapons,
            'categories' => $categories,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWeaponRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Weapon $weapon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weapon $weapon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWeaponRequest $request, Weapon $weapon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weapon $weapon)
    {
        //
    }
}
