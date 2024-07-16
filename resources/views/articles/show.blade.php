@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $article->title }}</h1>
    @if($article->is_premium && !Auth::user()->is_premium)
        <p>This content is for premium users only.</p>
    @else
        <p>{{ $article->content }}</p>
        @if($article->image)
            <div class="img-container">
                <img src="{{ asset('storage/' . str_replace('public/', '', $article->image)) }}" alt="Article Image" class="img-fluid">
            </div>
        @endif
    @endif
    <br>
    <!-- Button to edit article -->
    @if(Auth::id() == $article->user_id) <!-- Adjust this condition as per your authorization logic -->
        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-primary mt-4">Edit Article</a>
    @endif

    <hr>

    <h2>Comments</h2>
    @foreach($article->comments as $comment)
        <div class="comment mb-3">
            <p>{{ $comment->content }}</p>
            <small>by {{ $comment->user->name }} on {{ $comment->created_at->format('d M Y') }}</small>
            @if(Auth::id() == $comment->user_id)
                <div class="btn-group mt-2" role="group">
                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            @endif
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
