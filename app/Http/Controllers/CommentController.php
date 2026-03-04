<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Project;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'text' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $user = auth()->guard('client')->user() ?? auth()->user();

        if (!$user) {
            return back()->with('error', 'You must be logged in to comment.');
        }

        Comment::create([
            'text' => $request->text,
            'user_id' => $user->id,
            'project_id' => $project->id,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'text' => 'required|string|max:2000',
        ]);

        $user = auth()->guard('client')->user() ?? auth()->user();

        if (!$user || $comment->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->update(['text' => $request->text]);

        return back()->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->guard('client')->user() ?? auth()->user();

        if (!$user || $comment->user_id !== $user->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully.');
    }
}
