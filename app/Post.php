<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'user_id',
    ];

    /**
     * The relationship counts that should be eager loaded on every query.
     *
     * @var array
     */
    protected $withCount = [
        'reactions'
    ];

    protected $with = [
        'reactions'
    ];

    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function comments()
    {
        return $this->hasMany(\App\Comment::class);
    }

    /**
     * Get all of the post's reactions.
     */
    public function reactions()
    {
        return $this->morphMany(\App\Reaction::class, 'element');
    }
}
