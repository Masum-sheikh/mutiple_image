<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post List</title>
</head>
<body>
    <h1>Post List</h1>
    <a href="{{ route('posts.create') }}">Create New Post</a>
    <ul>
        @foreach ($posts as $post)
            <li>
                <h2>{{ $post->title }}</h2>
                <div>

                    <img src="{{ asset('uploads/' . $post->images->first()->image) }}" alt="Image" width="100">

                </div>
                <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                    <a href="{{ route('posts.edit', $post->id) }}">edit</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
