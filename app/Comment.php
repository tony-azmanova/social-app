<?php

namespace App;

use App\User;
use App\Reaction;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'user_id', 'post_id',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        'reactions'
    ];
    
    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get all of the reaction's of comment.
     */
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'element');
    }
    
}
