<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FriendshipPoints extends Model
{
    protected $fillable = [
        'user_id', 'friend_id', 'points',
    ];
    
      /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
