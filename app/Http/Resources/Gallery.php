<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Contracts\ImageServiceInterface;
use Carbon\Carbon;

class Gallery extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'user_id' => $this->user_id,
            'created_at' => Carbon::parse($this->created_at)->toDayDateTimeString(),
            'updated_at' => Carbon::parse($this->updated_at)->toDayDateTimeString(),
            'images' => $this->getImagesForGallery(),
        ];
    }

    public function getImagesForGallery()
    {
        try {
            if (!$this->images->isEmpty()){
                $galleryImages = resolve(ImageServiceInterface::class)->getInfoForMultipleImages($this->images);
                return $galleryImages->image;
            }
        } catch (\Exception $exception) {
            return null;
        }
    }
}
