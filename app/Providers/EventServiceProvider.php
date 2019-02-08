<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Events\UserAddedReaction;
use App\Events\UserRemovedReaction;
use App\Listeners\AddFriendshipPoints;
use App\Listeners\RemoveFriendshipPoints;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserAddedReaction::class => [
            AddFriendshipPoints::class,
          
        ],
        UserRemovedReaction::class => [
            RemoveFriendshipPoints::class,
        ],
    ];
    
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
