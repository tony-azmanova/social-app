<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Contracts\ImageServiceInterface;

class File extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request = null)
    {
        return [
            'info' => $this->getImageInfo(),
        ];
    }

    public function getImageInfo()
    {
        try {
            $images = resolve(ImageService::class)->getMultipleImages();
            return $images;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
