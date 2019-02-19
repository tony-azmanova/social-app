<?php

namespace App\Http\Resources;

use App\Comment as CommentModel;
use App\Reaction;
use Carbon\Carbon;
use App\Http\Resources\User;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'userHasReacted' => Reaction::isUserReactedToType(CommentModel::class, $this->id),
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
        ];
    }
}
