<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        $rules = [
            'body' => ['required', 'string', 'min:5', 'max:2000'],
        ];

        if (! auth()->check()) {
            $rules['guest_name']  = ['required', 'string', 'max:100'];
            $rules['guest_email'] = ['required', 'email', 'max:200'];
        }

        $data = $request->validate($rules);

        $post->comments()->create([
            'body'        => $data['body'],
            'user_id'     => auth()->id(),
            'guest_name'  => $data['guest_name'] ?? null,
            'guest_email' => $data['guest_email'] ?? null,
            'approved'    => auth()->check(),
        ]);

        $message = auth()->check()
            ? 'Commentaire publie.'
            : 'Votre commentaire est en attente de moderation.';

        return back()->with('success', $message);
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $this->authorize('moderate', $comment);

        $comment->update(['approved' => true]);

        return back()->with('success', 'Commentaire approuve.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Commentaire supprime.');
    }
}
