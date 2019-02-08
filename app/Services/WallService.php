<?php

namespace App\Services;

use App\User;
use App\Post;
use App\FriendshipPoints;

/**
 * Description of FrienshipService
 *
 * @author tony
 */
class WallService
{

    public function showResentFriendActivity($user)
    {
        $userFriends = User::getAllFriendsOfUser($user->id);
        if ($userFriends->isEmpty()) {
            return $this->getLatestUserPosts($user);
        }

        $userPoints = FriendshipPoints::where('user_id', $user->id)->orderBy('points', 'DESC')->get();
        if ($userPoints->isEmpty()) {
            foreach ($userFriends as $friend) {
                $friendsPosts = $this->getLatestUserPosts($friend);
            }
            return $friendsPosts->sortByDesc('created_at');
        }

       return $this->getLatestPostsByFriendshipPoints($user, $userPoints);
    }

    public function getLatestUserPosts($user)
    {
        return Post::where('user_id', $user->user_id)->with(['user','reactions', 'comments'])->latest()->paginate(10);
    }

    public function getLatestPostsByFriendshipPoints($user, $userPoints)
    {
        foreach ($userPoints as $points) {
            $userPosts =
                Post::where('user_id', $user->id)
                    ->orWhere('user_id', $points['friend_id'])
                    ->with(['user', 'reactions', 'comments'])
                    ->latest()
                    ->paginate(10);
        }
        return $userPosts->sortByDesc('created_at');
    }
}
