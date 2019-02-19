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
    const PAGINATION_ITEMS_FOR_PAGE = 10;

    public function showResentFriendActivity($user)
    {
        $userFriends = User::getAllFriendsOfUser($user->id);
        if ($userFriends->isEmpty()) {
            return $this->getLatestUserPosts($user->id);
        }

        $userPoints = FriendshipPoints::where('user_id', $user->id)->orderBy('points', 'DESC')->get();
        if ($userPoints->first()->points === 0) {
            foreach ($userFriends as $friend) {
                $friendsPosts = $this->getLatestUserPosts($friend->user_id);
            }
            $allUsersPosts = $this->getLatestUserPosts($user->id)->merge($friendsPosts);
            return $allUsersPosts->sortByDesc('created_at');
        }

       return $this->getLatestPostsByFriendshipPoints($user, $userPoints);
    }

    public function getLatestUserPosts($userId)
    {
        return Post::where('user_id', $userId)
                ->with(['user','reactions', 'comments'])
                ->latest()
                ->paginate(self::PAGINATION_ITEMS_FOR_PAGE);
    }

    public function getLatestPostsByFriendshipPoints($user, $userPoints)
    {
        foreach ($userPoints as $points) {
            $userPosts =
                Post::where('user_id', $user->id)
                    ->orWhere('user_id', $points['friend_id'])
                    ->with(['user', 'reactions', 'comments'])
                    ->latest()
                    ->paginate(self::PAGINATION_ITEMS_FOR_PAGE);
        }

        return $userPosts;
    }
}
