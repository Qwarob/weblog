<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = Auth::id();
        $comment->article_id = $article->id;
        $comment->save();

        return redirect()->route('articles.show', $article->id)->with('success', 'Comment added successfully.');
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comments.edit', compact('comment'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $this->authorize('update', $comment);

        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->route('articles.show', $comment->article_id)->with('success', 'Comment updated successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->route('articles.show', $comment->article_id)->with('success', 'Comment deleted successfully.');
    }
}

