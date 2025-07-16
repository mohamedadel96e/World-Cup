<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTeamRequest;
use App\Http\Requests\Admin\UpdateTeamRequest;
use App\Models\Team;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::latest()->paginate(10);
        return view('livewire.admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('livewire.admin.teams.create');
    }

    public function store(StoreTeamRequest $request, CloudinaryUploadService $cloudinary)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $folder = 'team_logos';
            $publicId = Str::slug($validated['name']);
            $validated['logo'] = $cloudinary->upload($request->file('logo'), $folder, $publicId);
        }

        Team::create($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
    }

    public function edit(Team $team)
    {
        return view('livewire.admin.teams.edit', compact('team'));
    }

    public function update(UpdateTeamRequest $request, Team $team, CloudinaryUploadService $cloudinary)
    {
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            $folder = 'team_logos';
            $publicId = Str::slug($validated['name']);
            $validated['logo'] = $cloudinary->upload($request->file('logo'), $folder, $publicId);
        }

        $team->update($validated);

        return redirect()->route('admin.teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        // Add logic here to prevent deletion if teams are in use by countries
        if ($team->countries()->exists()) {
            return redirect()->route('admin.teams.index')->with('error', 'Cannot delete a team that has countries assigned to it.');
        }

        $team->delete();
        return redirect()->route('admin.teams.index')->with('success', 'Team deleted successfully.');
    }
}
