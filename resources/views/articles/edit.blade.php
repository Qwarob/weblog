@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Article</h1>
    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ $article->title }}" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" required>{{ $article->content }}</textarea>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control">
            @if ($article->image)
                <img src="{{ asset('storage/' . str_replace('public/', '', $article->image)) }}" alt="Article Image" class="img-fluid mt-2">
            @endif
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category_id" class="form-control" required>
                <option value="">Select a Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $article->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="is_premium">Premium Content</label>
            <input type="checkbox" id="is_premium" name="is_premium" class="form-check-input" {{ $article->is_premium ? 'checked' : '' }}>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update Article</button>
    </form>
</div>
@endsection
