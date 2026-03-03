<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Store (invite) a new team member.
     */
    public function store(Request $request, $team_id)
    {
        $team = \App\Models\Team::where('id', $team_id)
            ->where('created_by', auth()->id())
            ->firstOrFail();

        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // Check if user is the creator
        if ($user->id === auth()->id()) {
            return back()->withErrors(['email' => 'You cannot invite yourself.']);
        }

        // Check if already invited or a member
        $existing = \App\Models\TeamMember::where('team_id', $team->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existing) {
            return back()->withErrors(['email' => 'User is already invited or a member of this team.']);
        }

        \App\Models\TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'status' => 'pending',
            'created_by' => auth()->id(),
        ]);

        return back()->with('success', 'Invitation sent successfully!');
    }

    /**
     * Remove a member or cancel invitation.
     */
    public function destroy($team_id, $member_id)
    {
        $team = \App\Models\Team::where('id', $team_id)
            ->where('created_by', auth()->id())
            ->firstOrFail();

        $member = \App\Models\TeamMember::where('team_id', $team->id)
            ->where('id', $member_id)
            ->firstOrFail();

        $member->delete();

        return back()->with('success', 'Member removed successfully.');
    }

    /**
     * View user's team invitations.
     */
    public function invitations()
    {
        $invitations = \App\Models\TeamMember::with('team.creator')
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('client.teams.invitations', compact('invitations'));
    }

    /**
     * Accept or reject an invitation.
     */
    public function updateStatus(Request $request, $invitation_id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $invitation = \App\Models\TeamMember::where('id', $invitation_id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $invitation->update([
            'status' => $request->status,
            'updated_by' => auth()->id()
        ]);

        $message = $request->status === 'approved' ? 'Invitation accepted!' : 'Invitation rejected.';
        return back()->with('success', $message);
    }
}
