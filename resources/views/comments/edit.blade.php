@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Comment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" required>{{ $comment->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Comment</button>
    </form>
</div>
@endsection
