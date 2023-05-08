<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => \App\Models\Post::latest()->paginate(20),
        ]);
    }

    public function show($id)
    {
        return view('posts.show', [
            'post' => Post::findOrFail($id),
        ]);
    }
    public function create()
    {
        $post = new Post();
        $post->fill([
            'title' => 'Title',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo sed molestiae assumenda modi, provident doloribus dolores quaerat natus sit, libero nulla eos molestias nobis! Omnis, tenetur maxime. Rerum, iure illum.Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo sed molestiae assumenda modi, provident doloribus dolores quaerat natus sit, libero nulla eos molestias nobis! Omnis, tenetur maxime. Rerum, iure illum. Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo sed molestiae assumenda modi, provident doloribus dolores quaerat natus sit, libero nulla eos molestias nobis! Omnis, tenetur maxime. Rerum, iure illum.Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo sed molestiae assumenda modi, provident doloribus dolores quaerat natus sit, libero nulla eos molestias nobis! Omnis, tenetur maxime. Rerum, iure illum.',
        ]);
        return view('posts.form', [
            'post' => $post,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|string',
            'image' => 'required|image|max:2000'
        ], [
            'title.required' => 'Titre requis.',
            'image.required' => 'Image requise.',
            'title.min' => 'Taille minimum 5.',
            'content.required' => 'Le contenu du post est vide.',
        ]);
        $data['image'] = $data['image']->store('blog', 'public');

        $post = Post::create($data);
        return redirect()->route('posts.show', $post->id)->with('success', 'Post bien crée');
    }

    public function edit(Post $post)
    {
        return view('posts.form', [
            'post' => $post,
        ]);
    }

    public function update(Post $post, Request $request)
    {
        $data = $request->validate([
            'title' => 'required|min:5',
            'content' => 'required|string',
            'image' => 'image|max:2000'
        ], [
            'title.required' => 'Titre requis.',
            'title.min' => 'Taille minimum 5.',
            'content.required' => 'Le contenu du post est vide.',
        ]);

        if ($request->image) {
            Storage::disk('public')->delete($post->image);
            $data['image'] = $request->image->store('blog', 'public');
        }
        $post->update($data);
        return redirect()->route('posts.show', $post->id)->with('success', 'Post bien modifié');
    }

    public function destroy(Post $post)
    {
        Storage::disk('public')->delete($post->image);
        $post->delete();
        return back();
    }
}
