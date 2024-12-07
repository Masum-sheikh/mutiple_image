<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>
<body>
    <h1>Create Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">Post Title:</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label for="images">Upload Images:</label>
            <input type="file" name="images[]" multiple>
        </div>
        <button type="submit">Save</button>
    </form>
</body>
</html>
 