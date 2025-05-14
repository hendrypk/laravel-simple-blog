<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Container\Attributes\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->where('status', Post::TYPE_ACTIVE)->get();
        return view ('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        if ($request->has('is_draft')) {
            $status = Post::TYPE_DRAFT;
            $publishedAt = null;
        } elseif (empty($request->published_at)) {
            $status = Post::TYPE_ACTIVE;
            $publishedAt = now();
        } else {
            $status = Post::TYPE_SCHEDULED;
            $publishedAt = $request->published_at;
        }

        $post = Post::create(
            [
                'user_id' => auth()->id(),
                'title' => $request->title,
                'content' => $request->content,
                'published_at' => $publishedAt,
                'status' => $status
            ]
        );

        return redirect()->route('posts.show', $post->id)->with('success', 'Post saved successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($request->has('is_draft')) {
            $status = Post::TYPE_DRAFT;
            $publishedAt = null;
        } elseif (empty($request->published_at)) {
            $status = Post::TYPE_ACTIVE;
            $publishedAt = now();
        } else {
            $status = Post::TYPE_SCHEDULED;
            $publishedAt = $request->published_at;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'published_at' => $publishedAt,
            'status' => $status
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Post updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }
}
