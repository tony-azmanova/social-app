<?php

namespace App\Http\Resources;

use App\Http\Resources\User;
use App\Post as PostModel;
use App\Reaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'user' => new User($this->user),
            'reactions' => $this->reactions_count,
            'userHasReacted' => Reaction::isUserReactedToType(PostModel::class, $this->id),
        ];
    }
}
