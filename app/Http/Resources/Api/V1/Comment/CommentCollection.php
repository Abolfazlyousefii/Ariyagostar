<?php

namespace App\Http\Resources\Api\V1\Comment;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($comment) {
            $comments = $comment->comments()->accepted()->latest()->get();

            return [
                'id'             => $comment->id,
                'user_id'        => $comment->user_id,
                'name'           => $comment->name(),
                'body'           => $comment->body,
                'image'          => $comment->user ? $comment->user->imageUrl() : null,
                'created_at'     => jdate($comment->created_at)->ago(),
                'comments'       => new CommentCollection($comments)
            ];
        });
    }
}
