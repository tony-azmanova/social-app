<?php

namespace App\Http\Resources;

use App\Services\Contracts\ImageServiceInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
{
    /**
     * Transform the resource collection into an array.
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
            $image = resolve(ImageServiceInterface::class)->getMultipleImages($this);
            return $image->image;
        } catch (\Exception $exception) {
            return null;
        }
    }
}
