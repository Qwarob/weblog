@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $article->title }}</h1>
    @if($article->is_premium && !Auth::user()->is_premium)
        <p>This content is for premium users only.</p>
    @else
        <p>{{ $article->content }}</p>
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="Article Image">
        @endif
    @endif
    <a href="{{ route('articles.index') }}" class="btn btn-secondary mt-4">Back to Articles</a>

    <hr>

    <h2>Comments</h2>
    @foreach($article->comments as $comment)
        <div class="comment mb-3">
            <p>{{ $comment->content }}</p>
            <small>by {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y') }}</small>
            @can('update', $comment)
                <div class="btn-group mt-2" role="group">
                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                @endcan
            @endcan
        </div>
        <hr>
    @endforeach

    @auth
    <form action="{{ route('comments.store', $article->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Add a comment:</label>
            <textarea id="content" name="content" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Submit</button>
    </form>
    @endauth
</div>
@endsection
