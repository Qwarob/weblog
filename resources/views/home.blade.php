@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mb-4">
            <h1>Welcome to the Blog</h1>
            @auth
                <a href="{{ route('articles.index') }}" class="btn btn-primary">View Articles</a>
            @endauth
        </div>
    </div>
@endsection
