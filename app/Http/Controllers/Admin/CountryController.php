<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCountryRequest;
use App\Http\Requests\Admin\UpdateCountryRequest;
use App\Models\Country;
use App\Models\Team;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::with('team')->latest()->paginate(10);
        return view('livewire.admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('livewire.admin.countries.create', [
            'teams' => Team::all(),
        ]);
    }

    public function store(StoreCountryRequest $request, CloudinaryUploadService $cloudinary)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $cloudinary->upload($request->file('logo'), 'country_logos', Str::slug($validated['name']) . '-logo');
        }
        if ($request->hasFile('flag')) {
            $validated['flag'] = $cloudinary->upload($request->file('flag'), 'country_flags', Str::slug($validated['name']) . '-flag');
        }

        Country::create($validated);

        return redirect()->route('admin.countries.index')->with('success', 'Country created successfully.');
    }

    public function edit(Country $country)
    {
        return view('livewire.admin.countries.edit', [
            'country' => $country,
            'teams' => Team::all(),
        ]);
    }

    public function update(UpdateCountryRequest $request, Country $country, CloudinaryUploadService $cloudinary)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $validated['logo'] = $cloudinary->upload($request->file('logo'), 'country_logos', Str::slug($validated['name']) . '-logo');
        }
        if ($request->hasFile('flag')) {
            $validated['flag'] = $cloudinary->upload($request->file('flag'), 'country_flags', Str::slug($validated['name']) . '-flag');
        }

        $country->update($validated);

        return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
    }

    public function destroy(Country $country)
    {
        if ($country->users()->exists() || $country->weapons()->exists()) {
            return redirect()->route('admin.countries.index')->with('error', 'Cannot delete country with associated users or weapons.');
        }

        $country->delete();
        return redirect()->route('admin.countries.index')->with('success', 'Country deleted successfully.');
    }
}
