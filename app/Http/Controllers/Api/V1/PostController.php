<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Comment\CommentCollection;
use App\Http\Resources\Api\V1\Post\PostCollection;
use App\Http\Resources\Api\V1\Post\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->per_page ?: 20;

        $posts = Post::published()
            ->apiFilter()
            ->latest()
            ->paginate($per_page);

        return $this->respondWithResourceCollection(new PostCollection($posts));
    }

    public function show(Post $post)
    {
        if (!$post->isPublished()) {
            abort(404);
        }

        return $this->respondWithResource(new PostResource($post));
    }

    public function comments(Post $post, Request $request)
    {
        $per_page = $request->per_page ?: 20;

        $comments = $post->comments()
            ->whereNull('comment_id')
            ->accepted()
            ->latest()
            ->paginate($per_page);

        return $this->respondWithResourceCollection(new CommentCollection($comments));
    }
}
