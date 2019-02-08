<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Contracts\ImageServiceInterface;

class User extends JsonResource
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
            'formated_full_name' => $this->formated_full_name,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->getAvatar(),
            'memberSince' => $this->created_at->diffForHumans(),
            'latestDates' => $this->getUserLatestDates(),
            'posts_count' => $this->posts_count,
            'files_count' => $this->files_count,
            'comments_count' => $this->comments_count,
        ];
    }

    public function getAvatar()
    {
        try {
            $image = resolve(ImageServiceInterface::class)->getInfoForImage($this->avatar);
            return $image;
        } catch (\Exception $exception) {
            return null;
        }
    }

    public function getUserLatestDates()
    {
        return [
            'latestPostDate' => $this->posts->isEmpty() ? 'Not added' : $this->posts()->latest()->first()->created_at->diffForHumans(),
            'latestImageDate' => $this->files->isEmpty() ? 'Not added': $this->files()->latest()->first()->created_at->diffForHumans(),
            'latestCommentDate' => $this->comments->isEmpty() ? 'Not added' : $this->comments()->latest()->first()->created_at->diffForHumans(),
        ];
    }
}
