<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('livewire.admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('livewire.admin.teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string',
            'logo' => 'nullable|image',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('teams', 'public');
        }
        try {
            Team::create($validated);
            return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not create team: ' . $e->getMessage()]);
        }
    }

    public function edit(Team $team)
    {
        return view('livewire.admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('teams', 'public');
        }
        try {
            $team->update($validated);
            return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['error' => 'Could not update team: ' . $e->getMessage()]);
        }
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Team deleted successfully.');
    }
}
