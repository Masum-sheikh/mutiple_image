<?php
// app/Http/Controllers/PostController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Image;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('images')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }
    public function edit($id)
    {
        $post = Post::with('images')->findOrFail($id);
        return view('posts.edit', compact('post'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = Post::create(['title' => $request->title]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename);

                Image::create([
                    'post_id' => $post->id,
                    'image' => $filename,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post and images uploaded successfully.');
    }

    public function show($id)
    {
        $post = Post::with('images')->findOrFail($id);
        return view('posts.show', compact('post'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $post = Post::findOrFail($id);

    foreach ($post->images as $image) {
        if (file_exists(public_path('uploads/' . $image->image))) {
            unlink(public_path('uploads/' . $image->image)); // Public folder থেকে ডিলেট
        }
         $image->delete(); // Database থেকে ডিলেট
    }



      // নতুন ইমেজ আপলোড
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            Image::create([
                'post_id' => $post->id,
                'image' => $filename,
            ]);
        }
    }

    return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
}

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        foreach ($post->images as $image) {
            if (file_exists(public_path('uploads/' . $image->image))) {
                unlink(public_path('uploads/' . $image->image));
            }
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post and images deleted successfully.');
    }
}
