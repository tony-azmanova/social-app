<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'originalName', 'pathToFile','mimeType','user_id'
    ];
    
    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
