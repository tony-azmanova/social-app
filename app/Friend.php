<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'recever_id','status'
    ];
}    
