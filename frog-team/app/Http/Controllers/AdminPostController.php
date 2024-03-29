<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $posts = Post::where('user_id', $user->id)->paginate(50);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }
    public function store()
    {   
        $validatedData = $this->validatePost();

        $thumbnail = request()->file('thumbnail');
        $thumbnailPath = $thumbnail->storeAs('thumbnails', $thumbnail->hashName(), 'public');

        Post::create(array_merge($validatedData, [
            'user_id' => request()->user()->id,
            'thumbnail' => $thumbnailPath,
        ]));

        return redirect('admin/posts')->with('success', 'Your post has been created successfully!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post)
    {
        $this->authorize('update', $post);

        $attributes = $this->validatePost($post);

        if ($attributes['thumbnail'] ?? false) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);

        return back()->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back()->with('success', 'Post Deleted!');
    }

    protected function validatePost(?Post $post = null): array
    {
        $post ??= new Post();

        return request()->validate([
            'title' => 'required',
            'thumbnail' => $post->exists ? 'image' : 'required|image',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post)],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories', 'id')]
        ]);
    }
}