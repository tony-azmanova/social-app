<?php

namespace App;

use App\File;
use App\Gallery;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gallery_id', 'file_id',
    ];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['file'];

    /**
     * Get the gallery that is related to the image.
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get the file record associated with the image.
     */
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function findImageInGallery($imageId, $galleryId)
    {
        Image::where('file_id', $imageId)
            ->where('gallery_id', $galleryId)->get();
    }
}
