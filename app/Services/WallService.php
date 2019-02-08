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
        //if the user does not have any friends check to see if he has any posts
        if ($userFriends->isEmpty()) {
            return Post::where('user_id', $user->user_id)->with('user')->latest()->paginate(10);
        }
        //if user do not have any friendship points show the posts of all his friends
        $userPoints = $user->friendshipPoints()->get();
        if ($userPoints->isEmpty()) {
            foreach ($userFriends as $friend) {
                $friendsPosts = Post::where('user_id', $friend->user_id)->with('user')->latest()->paginate(10);
            }
            return $friendsPosts->sortByDesc('created_at');
        }
        //if user has friendsip points show the post of the user friends with the high points
        $userPoints= FriendshipPoints::where('user_id', $user->id)->orderBy('points', 'DESC')->get();

        foreach ($userPoints as $points) {
            $userPosts =
                Post::where('user_id', $user->id)
                    ->orWhere('user_id', $points['friend_id'])
                    ->with('user', 'comments')
                    ->latest()
                    ->paginate(10);
        }
        return $userPosts->sortByDesc('created_at');
    }
}
