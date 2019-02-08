<?php

namespace App\Listeners;

use App\Events\UserRemovedReaction;
use App\FriendshipPoints;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveFriendshipPoints
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
     * @param  UserRemovedReaction  $event
     * @return void
     */
    public function handle(UserRemovedReaction $event)
    {
        $friendshipPoint = FriendshipPoints::where('user_id', auth()->id())
           ->where('friend_id', $event->user->id);
        
        if ($friendshipPoint->get()->isNotEmpty()) {
           return $friendshipPoint->decrement('points');
        }
        
        return FriendshipPoints::create([
            'user_id' => auth()->id(),
            'friend_id' => $event->user->id,
        ]);
    }
}
