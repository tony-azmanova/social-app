<?php

namespace App\Listeners;

use App\Events\UserAddedReaction;
use App\FriendshipPoints;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddFriendshipPoints
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  UserAddedReaction  $event
     * @return void
     */
    public function handle(UserAddedReaction $event)
    {
        $friendshipPoint = FriendshipPoints::where('user_id', auth()->id())
           ->where('friend_id', $event->user->id);

        if ($friendshipPoint->get()->isNotEmpty()) {
           return $friendshipPoint->increment('points');
        }

        return FriendshipPoints::create([
            'user_id' => auth()->id(),
            'friend_id' => $event->user->id,
        ]);
    }
}
