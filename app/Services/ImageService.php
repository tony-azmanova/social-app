<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
use App\Services\Contracts\ImageServiceInterface;
use InterventionImage;

/**
 * Description of ImageService
 *
 * @author tony
 */
class ImageService implements ImageServiceInterface
{
    private $allowedMimeTypes = ['image/jpeg','image/gif','image/png'];

    private $sizes = [200, 500, 800];

    const NO_IMAGE_FOUND_PATH = 'files/images/default/no_image_found.png';
    
    const USER_DEFAULT_IMAGE_PATH = 'files/images/default/user_default.png';

    /**
     * Check if the image is of valid type
     * 
     * @param type $image
     * @return boolean
     */
    public function checkIfFileIsValidImageType($image)
    {
        return (in_array($image->getClientMimeType(), $this->allowedMimeTypes));
    }

    public function getFileDirectory($filePath)
    {
        $fileInfo = pathinfo($filePath);
        
        return $fileInfo['dirname'];
    }

    /**
     * Create thumbnails with different sizes for the given image 
     * 
     * @param type $imagePath
     * 
     * @param \App\Services\type $imagePath
     * @param type $sizes
     */
    public function createThumbnails($imagePath, $sizes)
    {
        $thumbnailsDirectory = 'public/'.$this->getFileDirectory($imagePath).'/thumbnails/';
        Storage::makeDirectory($thumbnailsDirectory);

        foreach ($sizes as $size) {
            InterventionImage::make(storage_path('app/public/'.$imagePath))
                ->fit($size)
                ->save(storage_path('app/'. $this->buildThumbnailPath($imagePath, $size)));
        }
    }

    /**
     * Needs to b re-done
     * 
     * @param type $userId
     * @return \stdClass
     */
    public function getMultipleImages($userFiles)
    {
        $images = new \stdClass();

        foreach ($userFiles as $file) {
            $images->image[] = $this->getInfoForImage($file);
        }
        return $images;
    }
   
    public function getInfoForImage($file, $size = 200)
    {
        $image = new \stdClass();

        if (!$file) {
            $image->storagePath = self::USER_DEFAULT_IMAGE_PATH;
            $image->thumbnail = $this->getThumbnailWithSize(self::USER_DEFAULT_IMAGE_PATH, $size);
          
            return $image;
        }
        $image->storagePath = $this->getImage($file->pathToFile);
        $image->name = $file->originalName;
        $image->info = $file;
        $image->thumbnail = $this->getThumbnailWithSize($file->pathToFile, $size);

        return $image;
    }

    /**
     * Get the image
     * @param type $imagePath
     * @return string
     */
    public function getImage($imagePath)
    {
        if (!Storage::exists($this->buildImagePath($imagePath))) {
            return self::NO_IMAGE_FOUND_PATH;
        }
        return $imagePath;
    }

    public function getInfoForMultipleImages($imageFiles)
    {
        $images = new \stdClass();

        foreach ($imageFiles as $image) {
            $images->image[] = $this->getInfoForImage($image->file);
        }
        return $images;
    }

    /**
     * Get the thumbnail path by given image path and size
     * 
     * @param type $imagePath
     * @param type $size
     * @return string
     */
    public function getThumbnailWithSize($imagePath, $size)
    {
        $hasThumbnail = Storage::exists($this->buildThumbnailPath($imagePath, $size));
        $hasImageSource = Storage::exists($this->buildImagePath($imagePath));

        if (!$hasThumbnail && $hasImageSource ) {
            return $this->createThumbnails($imagePath, $this->sizes);
        }
        if (!$hasThumbnail && !$hasImageSource) {
            return $this->getPublicThumbnailPath(self::NO_IMAGE_FOUND_PATH);
        }
        return $this->getPublicThumbnailPath($imagePath, $size);
    }

    /**
     * Delete all thumbnails for image
     * 
     * @param type $imagePath
     */
    public function deleteAllThumbnailsForImage($imagePath)
    {
        if (Storage::exists($this->buildThumbnailPath($imagePath))) {
            foreach ($this->sizes as $size) {
                Storage::delete($this->buildThumbnailPath($imagePath, $size));
            }
            return true;
        }
    }

    /**
     * Delete image from storage
     * 
     * @param type $imagePath
     */
    public function deleteImage($imagePath)
    {
        if ($this->buildImagePath($imagePath) && $this->deleteAllThumbnailsForImage($imagePath)) {
            Storage::delete($this->buildImagePath($imagePath));
        } 
    }

    public function buildThumbnailPath($imagePath, $size = 200)
    {
        $name = File::name($imagePath);
        $extension = File::extension($imagePath);
        $directory = $this->getFileDirectory($imagePath);

        return 'public/'.$directory.'/thumbnails/'.$name.'_'. $size.'.'.$extension;
    }

    public function buildImagePath($imagePath)
    {
        $name = File::name($imagePath);
        $extension = File::extension($imagePath);
        $directory = $this->getFileDirectory($imagePath);

        return 'public/'.$directory.'/'.$name.'.'.$extension;
    }

    public function getPublicThumbnailPath($imagePath, $size = 200)
    {
        return Storage::url($this->buildThumbnailPath($imagePath, $size));
    }
}
