<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return view('images.index', compact('images'));
    }

    public function create()
    {
        return view('images.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $filename = time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('uploads'), $filename); // public/uploads ডিরেক্টরিতে ফাইল সংরক্ষণ

                Image::create(['image' => $filename]);
            }
        }

        return redirect()->route('images.index')->with('success', 'Images uploaded successfully.');
    }


    public function edit($id)
    {
        $image = Image::findOrFail($id);
        return view('images.edit', compact('image'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = Image::findOrFail($id);

        if ($request->hasFile('image')) {
            // পুরানো ফাইল ডিলিট করা
            if (file_exists(public_path('uploads/' . $image->image))) {
                unlink(public_path('uploads/' . $image->image));
            }

            // নতুন ফাইল আপলোড করা
            $filename = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads'), $filename);

            $image->update(['image' => $filename]);
        }

        return redirect()->route('images.index')->with('success', 'Image updated successfully.');
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // public/uploads থেকে ফাইল ডিলিট করা
        if (file_exists(public_path('uploads/' . $image->image))) {
            unlink(public_path('uploads/' . $image->image));
        }

        $image->delete();

        return redirect()->route('images.index')->with('success', 'Image deleted successfully.');
    }

}

