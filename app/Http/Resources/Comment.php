<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Reaction;
use Carbon\Carbon;
use App\Http\Resources\User;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'user' => new User($this->user),
            'reactions' => $this->reactions_count,
            'userHasReacted' => Reaction::isUserReactedToType(\App\Comment::class, $this->id),
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
        ];
    }
}
