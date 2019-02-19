<?php

namespace App;

use App\User;
use App\File;
use App\Post;
use App\Comment;
use Carbon\Carbon;
use App\FriendshipPoints;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = [
        'avatar'
    ];

    /**
     * Get the comments for the blog post.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function avatar()
    {
        return $this->hasOne(File::class, 'id', 'avatar_file_id');
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function friendshipPoints()
    {
        return $this->hasMany(FriendshipPoints::class);
    }

    public function friends()
    {
        return $this->belongsToMany(
            User::class,
            'user_friends',
            'user_id',
            'friend_id'
        )->withTimestamps();
    }

    public static function getAllFriendsOfUser($userId)
    {
        $userFriends = DB::table('users')->select(['users.*', 'user_friends.created_at as friendship_created_at'])
                ->join('user_friends', 'users.id', '=', 'user_friends.user_id')
                ->where('user_friends.friend_id', $userId);

        $result =  DB::table('users')->select(['users.*', 'user_friends.created_at as friendship_created_at'])
                ->join('user_friends', 'users.id', '=', 'user_friends.friend_id')
                ->where('user_friends.user_id', $userId)
                ->union($userFriends)->get();

        return User::hydrate($result->toArray());
    }
    
    /**
     * Get all of the files of user.
     */
    public function files()
    {
        return $this->hasMany(File::class);
    }
    
    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }
    
    public function getFilesCountAttribute()
    {
        return $this->files()->count();
    }
    
    public function getCommentsCountAttribute()
    {
        return $this->comments()->count();
    }
    
    /**
    * Get the user's full name.
    *
    * @return string
    */
    public function getFormatedFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    public function getFriendshipCreatedAtAttribute()        
    {
        return Carbon::parse($this->getAttributeFromArray('friendship_created_at')); 
    }

    public function scopeSearchUsersBySearchTerm($query, $searchTerm)
    {
        if ($searchTerm!='') {
            $query->where(function ($query) use ($searchTerm) {
                $query->where("first_name", "LIKE","%$searchTerm%")
                    ->where("last_name", "LIKE", "%$searchTerm%")
                    ->orWhere("first_name", "LIKE", "%$searchTerm%")
                    ->orWhere("last_name", "LIKE", "%$searchTerm%");
                    
            });
        }
        return $query;
    }
}
