<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Weapon;
use Illuminate\Http\Request;

class WeaponController extends Controller
{
    public function index()
    {
        $weapons = Weapon::all();
        return view('livewire.admin.weapons.index', compact('weapons'));
    }

    public function create()
    {
        return view('livewire.admin.weapons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'base_price' => 'required|integer',
            'manufacturer_price' => 'required|integer',
            'discount_percentage' => 'required|integer',
            'image_path' => 'nullable|image',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);
        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('weapons', 'public');
        }
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');
        try {
            Weapon::create($validated);
            return redirect()->route('admin.weapons.index')->with('success', 'Weapon created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not create weapon: ' . $e->getMessage()]);
        }
    }

    public function edit(Weapon $weapon)
    {
        return view('livewire.admin.weapons.edit', compact('weapon'));
    }

    public function update(Request $request, Weapon $weapon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'base_price' => 'required|integer',
            'manufacturer_price' => 'required|integer',
            'discount_percentage' => 'required|integer',
            'image_path' => 'nullable|image',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);
        if ($request->hasFile('image_path')) {
            $validated['image_path'] = $request->file('image_path')->store('weapons', 'public');
        }
        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');
        try {
            $weapon->update($validated);
            return redirect()->route('admin.weapons.index')->with('success', 'Weapon updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not update weapon: ' . $e->getMessage()]);
        }
    }

    public function destroy(Weapon $weapon)
    {
        $weapon->delete();
        return redirect()->route('admin.weapons.index')->with('success', 'Weapon deleted successfully.');
    }
}
