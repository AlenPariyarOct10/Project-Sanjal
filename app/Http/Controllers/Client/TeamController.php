<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Team::where(function ($q) {
            $q->where('created_by', auth()->id())
                ->orWhereIn('id', function ($sub) {
                $sub->select('team_id')
                    ->from('team_members')
                    ->where('user_id', auth()->id())
                    ->where('status', 'approved');
            }
            );
        });

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $teams = $query->latest()->paginate(10)->withQueryString();
        return view('client.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('client.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
            'members' => 'nullable|array',
            'members.*' => 'nullable|email|exists:users,email',
        ], [
            'members.*.exists' => 'One or more of the invited email addresses do not exist in our system.',
            'members.*.email' => 'Please enter a valid email address.',
        ]);

        $team = new \App\Models\Team($request->except(['logo', 'members']));
        $team->created_by = auth()->id();

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('teams', 'public');
            $team->logo = $path;
        }

        $team->save();

        if ($request->filled('members')) {
            $emails = array_unique(array_filter($request->members));

            $userIds = \App\Models\User::whereIn('email', $emails)
                ->where('id', '!=', auth()->id())
                ->pluck('id');

            foreach ($userIds as $userId) {
                \App\Models\TeamMember::create([
                    'team_id' => $team->id,
                    'user_id' => $userId,
                    'status' => 'pending',
                    'created_by' => auth()->id(),
                ]);
            }
        }

        return redirect()->route('client.teams.index')->with('success', 'Team created successfully!');
    }

    public function show(string $id)
    {
        $team = \App\Models\Team::where('id', $id)
            ->where(function ($q) {
            $q->where('created_by', auth()->id())
                ->orWhereIn('id', function ($sub) {
                $sub->select('team_id')
                    ->from('team_members')
                    ->where('user_id', auth()->id())
                    ->where('status', 'approved');
            }
            );
        })->firstOrFail();
        return view('client.teams.show', compact('team'));
    }

    public function edit(string $id)
    {
        $team = \App\Models\Team::where('id', $id)->where('created_by', auth()->id())->firstOrFail();
        return view('client.teams.edit', compact('team'));
    }

    public function update(Request $request, string $id)
    {
        $team = \App\Models\Team::where('id', $id)->where('created_by', auth()->id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'logo' => 'nullable|image|max:2048',
        ]);

        $team->fill($request->except('logo'));

        if ($request->hasFile('logo')) {
            if ($team->logo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($team->logo);
            }
            $path = $request->file('logo')->store('teams', 'public');
            $team->logo = $path;
        }

        $team->save();

        return redirect()->route('client.teams.index')->with('success', 'Team updated successfully!');
    }

    public function destroy(string $id)
    {
        $team = \App\Models\Team::where('id', $id)->where('created_by', auth()->id())->firstOrFail();

        if ($team->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($team->logo);
        }

        $team->delete();

        return redirect()->route('client.teams.index')->with('success', 'Team deleted successfully!');
    }
}
