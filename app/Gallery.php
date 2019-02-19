<?php

namespace App;

use App\Image;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_id',
    ];
    /**
     * Get the user that owns the post.
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
