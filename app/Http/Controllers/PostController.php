<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        DB::beginTransaction();
        $validated = $request->validated();
        $validated['created_by_id'] = Auth::id();

        $post = Post::create($validated);
        $post->tags()->sync($validated['tags']);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $post->addMedia($image)->toMediaCollection('images');
            }
        }
        DB::commit();

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post->load('tags')->setHidden(['media']),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post['images'] = $post->getMedia('images')->map(function ($image) {
            return $image->getUrl();
        });
        return response()->json($post->load('tags')->makeHidden(['media']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        DB::beginTransaction();
        $validated = $request->validated();

        $post->getMedia('images')->each->delete();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $post->addMedia($image)->toMediaCollection('images');
            }
        }

        $post->update($validated);
        $post->tags()->sync($validated['tags']);

        $post->save();
        DB::commit();

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post->load('tags')->setHidden(['media']),
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        DB::beginTransaction();
        $post->getMedia('images')->each->delete();
        $post->delete();
        DB::commit();

        return response()->json([
            'message' => 'Post deleted successfully',
            'post' => $post->setHidden(['media']),
        ], 201);
    }
}
