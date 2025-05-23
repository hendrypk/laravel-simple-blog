<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {           
        return view ('posts.index', 
            ['posts' => Post::where('status', Post::TYPE_ACTIVE)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view ('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->has('is_draft')) {
            $status = Post::TYPE_DRAFT;
            $publishedAt = null;
        } else {
            $publishedAt = $validated['published_at'] ?? now();
            $status = now()->gte($publishedAt)
                ? Post::TYPE_ACTIVE
                : Post::TYPE_SCHEDULED;
        }

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $publishedAt,
            'status' => $status
        ]);

        return to_route('posts.show', $post->id)
            ->with('success', 'Post saved successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Post $post):View
    {
        if (
            auth()->guest() || auth()->id() !== $post->user_id &&
            (
                $post->status !== Post::TYPE_ACTIVE ||
                ($post->published_at && $post->published_at->isFuture())
            )
        ) {
            abort(403, 'Unauthorized');
        }
        return view('posts.show',
            compact('post')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post):View
    {
        if (auth()->id() !== $post->user_id) {
            abort(403, 'Unauthorized');
        }
        
        return view('posts.edit',
            compact('post')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->has('is_draft')) {
            $status = Post::TYPE_DRAFT;
            $publishedAt = null;
        } else {
            $publishedAt = $validated['published_at'] ?? now();
            $status = now()->gte($publishedAt)
                ? Post::TYPE_ACTIVE
                : Post::TYPE_SCHEDULED;
        }

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'published_at' => $publishedAt,
            'status' => $status
        ]);

        return to_route('posts.show', $post->id)
            ->with('success', 'Post updated successfully.');
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
