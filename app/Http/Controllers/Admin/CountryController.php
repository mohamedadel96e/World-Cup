<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('livewire.admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('livewire.admin.countries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:countries,code',
            'team_id' => 'required|exists:teams,id',
            'currency_name' => 'required|string',
            'currency_code' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:5',
            'balance' => 'required|integer',
            'logo' => 'nullable|image',
            'flag' => 'nullable|image',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('countries', 'public');
        }
        if ($request->hasFile('flag')) {
            $validated['flag'] = $request->file('flag')->store('countries', 'public');
        }
        try {
            Country::create($validated);
            return redirect()->route('admin.countries.index')->with('success', 'Country created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not create country: ' . $e->getMessage()]);
        }
    }

    public function edit(Country $country)
    {
        return view('livewire.admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:countries,code,' . $country->id,
            'team_id' => 'required|exists:teams,id',
            'currency_name' => 'required|string',
            'currency_code' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:5',
            'balance' => 'required|integer',
            'logo' => 'nullable|image',
            'flag' => 'nullable|image',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('countries', 'public');
        }
        if ($request->hasFile('flag')) {
            $validated['flag'] = $request->file('flag')->store('countries', 'public');
        }
        try {
            $country->update($validated);
            return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not update country: ' . $e->getMessage()]);
        }
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.countries.index')->with('success', 'Country deleted successfully.');
    }
}
