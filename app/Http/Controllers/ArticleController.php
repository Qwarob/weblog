<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('category') && $request->input('category') != '') {
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
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required',
            'is_premium' => 'nullable|boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $data['image'] = $path;
        }

        $article = Article::create($data);

        return redirect()->route('articles.show', $article->id)->with('success', 'Article created successfully.');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        // Check if the authenticated user is authorized to edit the article
        $this->authorize('update', $article);

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_premium' => 'boolean',
        ]);

        // Check if the authenticated user is authorized to update the article
        $this->authorize('update', $article);

        // Update article details
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->category_id = $request->input('category_id');
        $article->is_premium = $request->has('is_premium');

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $article->image = $imagePath;
        }

        // Save the updated article
        $article->save();

        return redirect()->route('articles.show', $article->id)->with('success', 'Article updated successfully.');
    }
    
    public function destroy(Article $article)
    {
        // Optionally, add authorization logic here
        // if (Auth::id() !== $article->user_id) {
        //     abort(403);
        // }

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
