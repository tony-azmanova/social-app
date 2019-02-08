<?php

namespace App\Http\Controllers;

use App\User;
use App\Friend;
use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\FriendshipService;
use App\Notifications\FriendshipSend;
use App\Http\Resources\User as UserResource;

class FriendsController extends Controller
{
    private $friendshipService;
    
    
    public function __construct(FriendshipService $friendshipService)
    {
        $this->friendshipService = $friendshipService;
    }
    
    /**
     * Add friend
     */
    public function addFriend(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        if ($this->friendshipService->checkFriendRequesStatus($userId)) {
            $user->notify(new FriendshipSend(User::findOrFail(auth()->id())));
            $this->store($request, $userId);
        }

        return JsonService::jsonSuccess(
            'Friendship request send!',
            $this->friendshipService->checkFriendRequesStatus($userId)
        );
    }

    /**
     * Store friends
     * 
     * @param Request $request
     * @param type $userId
     */
    public function store(Request $request, $userId) 
    {
        $friendsModel = Friend::create([
            'sender_id' => auth()->id(),
            'recever_id' => $userId,
            'status' => 'pending',   
        ]);
    }

    /**
     * Accept friendship request
     * 
     * @param type $notificationId
     * @return type
     */
    public function acceptFriendRequest($notificationId)
    {
        $crrentUser =  User::findOrFail(auth()->id());
        $notification = $crrentUser->unreadNotifications->where('id', $notificationId)->first();
        $crrentUser->friends()->attach([$notification->data['sender_id']]);

        return JsonService::jsonSuccess(
            'Friendship accepted!',
            $this->friendshipService->changeStatus('accepted', $notification)
        );
    }

    /**
     * Cancel friendship request
     * 
     * @param type $notificationId
     * @return type
     */
    public function cancelFriendRequest($notificationId)
    {
        $user =  User::findOrFail(auth()->id());
        $notification = $user->unreadNotifications->where('id', $notificationId)->first();

        return JsonService::jsonSuccess(
            'Friendship canceled!',
            $this->friendshipService->changeStatus('cancel', $notification)
        );
    }

    /**
     * Show all friends of current user
     */
    public function show()
    {
        $friends = User::getAllFriendsOfUser(auth()->id());
        if ($friends->isEmpty()) {
            return JsonService::jsonError(
                'You do not have any friends yet!',
                404
            );
        }

        return JsonService::jsonSuccess(
            'Returning all of the user friends!',
            UserResource::collection(User::getAllFriendsOfUser(auth()->id()))
        );
    }

    /**
     * Check Friendship status by given userId
     * 
     * @param integer $userId
     */
    public function friendshipStatus($userId)
    {
        return JsonService::jsonSuccess(
            'Returning friendshipStatus!',
            $this->friendshipService->checkFriendRequesStatus($userId)
        );
    }
}
