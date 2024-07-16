@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-9"> <!-- Adjust the column size as per your design -->
        <h1>Articles</h1>
        </div>
        <div class="col-md-3">
            <form method="GET" action="{{ route('articles.index') }}">
                <div class="input-group">
                    <select id="category" name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card">
                    @if($article->image)
                        <div class="img-container">
                            <img src="{{ asset('storage/' . str_replace('public/', '', $article->image)) }}" alt="Article Image" class="img-fluid">
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a>
                        </h5>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit(\Illuminate\Support\Str::before($article->content, '.'), 100) }}...
                        </p>
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-secondary">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<style>
.img-container {
    width: 100%;
    height: 200px; /* Adjust the height as needed */
    overflow: hidden;
    position: relative;
    margin-top: 10px;
}

.img-container img {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: auto;
    height: 100%;
}
</style>
