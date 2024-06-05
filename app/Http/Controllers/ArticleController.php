<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $articles = $query->get();
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image',
            'is_premium' => 'boolean',
        ]);
    
        $path = $request->file('image') ? $request->file('image')->store('images') : null;
    
        Article::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $path,
            'is_premium' => $request->has('is_premium'),
        ]);
    
        return redirect()->route('articles.index')
        ->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Category::all();
        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image',
            'is_premium' => 'boolean',
        ]);

        $path = $request->file('image') ? $request->file('image')->store('images') : $article->image;

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $path,
            'is_premium' => $request->has('is_premium'),
        ]);

        return redirect()->route('articles.index')
            ->with('success', 'Article updated successfully.');
    }
    
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index')
            ->with('success', 'Article deleted successfully.');
    }

    public function myArticles()
    {
        $articles = Auth::user()->articles; // Assuming you have a relationship set up
        return view('articles.my_articles', compact('articles'));
    }
}
