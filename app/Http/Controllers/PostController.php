<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\AddPostRequest;
use App\Services\JsonService;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\Post as PostResource;

/**
 * Description of PostController
 *
 * @author tony
 */
class PostController extends Controller
{

    /**
     * Return all for post by given id
     * 
     * @param integer $postId
     */
    public function show($postId)
    {
        return JsonService::jsonSuccess(
            'Returning all for a post!',
            PostResource::make(Post::findOrFail($postId))
        );
    }

    /**
     * Store new post in db
     * 
     * @param Request $request
     * @return type
     */
    public function store(AddPostRequest $request)
    {
        $validated = $request->validated();

        if (!$validated) {
            return JsonService::jsonError($validated->errors()->first());
        }

        $post = Post::create([
            'title' => $request->postTitle,
            'content' => $request->postContent,
            'user_id' => auth()->id(),
        ]);

        return JsonService::jsonSuccess(
            'Post was created successfully!',
            PostResource::make(Post::findOrFail($post->id))
        );
    }

    /**
     * Retirn all comments to given post
     * 
     * @param Request $request
     * @param integer $postId
     */
    public function postComment(Request $request, $postId)
    {
        return JsonService::jsonSuccess(
            'Returning comments to post!',
            CommentResource::collection(Post::findOrFail($postId)->comments)
        );
    }
}
