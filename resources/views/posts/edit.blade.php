<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Image</title>
</head>
<body>
    <h1>Edit Image</h1>
    <form action="{{ route('images.update', $image->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="file" name="image">
        <button type="submit">Update</button>
    </form>
</body>
</html>
