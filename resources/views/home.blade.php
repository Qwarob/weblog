<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h1>Welcome to the Blog</h1>
    <a href="{{ route('articles.create') }}">Create New Article</a>
    <ul>
        @foreach ($articles as $article)
            <li><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></li>
        @endforeach
    </ul>
</body>
</html>
