<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Services\JsonService;
use App\Http\Requests\AddCommentRequest;
use App\Http\Resources\Comment as CommentResource;

class CommentController extends Controller
{

    public function store(AddCommentRequest $request, $postId)
    {
        $validated = $request->validated();

        if (!$validated) {
            return JsonService::jsonError($validated->errors()->first());
        }

        $post = Post::findOrFail($postId);

        $comment = Comment::create([
            'title' => $request->commentTitle,
            'body' => $request->commentContent,
            'user_id' => auth()->id(),
            'post_id' => $post->id
        ]);    

        return JsonService::jsonSuccess(
            'Comment was added to post!',
            CommentResource::make(Comment::findOrFail($comment->id))
        );
    }
}
