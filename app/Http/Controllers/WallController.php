<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\WallService;
use App\Services\JsonService;
use App\Http\Resources\Post as PostResource;

class WallController extends Controller
{

    /**
     * @var type 
     */
    private $wallService;

    /**
     * @param WallService $wallService
     */
    public function __construct(WallService $wallService)
    {
        $this->wallService = $wallService;
    }

    /**
     * Wall where user can see all of his and his friends posts
     * 
     * @return type
     */
    public function index()
    {
        $posts = $this->wallService->showResentFriendActivity(auth()->user());

        if ($posts->isEmpty()) {
            return JsonService::jsonError(
                'You do not have any posts yet!',
                404
            );
        }
        
        return JsonService::jsonSuccess(
            'Returning all posts for current auth user!',
            PostResource::collection($posts)
        );
    }

    /**
     * Show wall of specific user
     * 
     * @param type $userId
     */
    public function show($userId)
    {
        $usersPosts = Post::where('user_id', $userId);

        if ($usersPosts->get()->isEmpty()) {
            return JsonService::jsonError(
                'You do not have any posts yet!',
                404
            );
        }

        return JsonService::jsonSuccess(
            'Returning all posts for user specific wall!',
            PostResource::collection($usersPosts->with(['user', 'reactions'])->latest()->paginate(10))
        );
    }
}
