<?php

namespace App\Http\Controllers;
use App\Post;
use App\Reaction;
use Illuminate\Http\Request;
use App\Services\WallService;
use App\Services\JsonService;
use App\Services\ReactionService;
use App\Events\UserAddedReaction;
use App\Events\UserRemovedReaction;

use App\Http\Resources\Reaction as ReactionResource;

class ReactionController extends Controller
{   
    protected $reactionService;
    
    protected $wallService;
    
    public function __construct(ReactionService $reactionService, WallService $wallService)
    {
        $this->reactionService = $reactionService;
        $this->wallService = $wallService;
    }
    
    public function create(Request $request)
    {
        $reactableType = $this->reactionService->getReactableType($request->reactionType);
        $id = $request->element['id'];
  
        $createReaction = Reaction::createOrDelete($reactableType, $id);
        $this->updateFrienshipPointsEvents($reactableType, $id, $createReaction);
        
        $userReactionToType = $reactableType::findOrFail($id)
            ->reactions()
            ->where('user_id', auth()->id())
            ->where('element_type', $reactableType)->get();

        //Change to Use the JsonService
        return response()->json([
            'success' => true,
            'elementId' => $id,
            'createdReaction' => $createReaction,
            'reactiosCount' => $reactableType::findOrFail($id)->reactions()->count(),
            'userHasReacted' => ($userReactionToType->isNotEmpty()) ? true : false,
        ]);
    }
    
    public function updateFrienshipPointsEvents($reactableType, $id, $createReaction)
    {
        $elementOwner = $reactableType::findOrFail($id)->user;
        if ($createReaction) {
           return event(new UserAddedReaction($elementOwner));
        }
       return event(new UserRemovedReaction($elementOwner));
    }
    
    
    public function isUserReactedToPost(Request $request)
    {
        $reactableModel = $this->reactionService->getModelForReactionType($request);
        $user = \App\User::findOrFail(auth()->id());

        $posts =  $this->wallService->showResentFriendActivity($user);
        $postsWithLike = [];
        foreach ($posts as $post) {
            $postsWithLike[$post['id']][] = Reaction::isUserReactedToType($reactableModel, $post['id']);
        }
        
        return JsonService::jsonSuccess('Returning all posts with likes for the user!', $postsWithLike);
    }

    public function show($elementId, $element)
    {
        $reactableModel = $this->reactionService->getReactionTypeByElementType($element, $elementId);
        
        $reactionCount = Post::findOrFail($id)->reactions()->count();
        $result = [
            'id' => $id,
            'count' => $reactionCount
        ];
        return JsonService::jsonSuccess('Returning reactions to post!', $result);
    }
}
