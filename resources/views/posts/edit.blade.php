<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
</head>
<body>
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Post Title:</label>
            <input type="text" name="title" value="{{ $post->title }}" required>
        </div>

        <div>
            <label for="images">Upload New Images (Optional):</label>
            <input type="file" name="images[]" multiple>
        </div>

        <div>
            <h3>Existing Images:</h3>
            @foreach ($post->images as $image)
                <div style="display: inline-block; margin-right: 10px;">
                    <img src="{{ asset('uploads/' . $image->image) }}" alt="Image" width="100">
                   
                </div>
            @endforeach
        </div>

        <button type="submit">Update</button>
    </form>
</body>
</html>
