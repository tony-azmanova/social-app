<?php

namespace App\Http\Controllers;

use App\File;
use App\Image;
use App\Gallery;
use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\ImageService;
use App\Http\Requests\StoreGallery;
use App\Http\Requests\AddToGalleryRequest;
use App\Http\Resources\Gallery as GalleryResource;

class GalleryController extends Controller
{

    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Show all galleries
     */
    public function index()
    {
        $galleries = Gallery::where('user_id', auth()->id())->get();
        if ($galleries->isEmpty()) {
            return JsonService::jsonError(
                'You do not have any gallery created yet!',
                404
            );
        }

        return JsonService::jsonSuccess(
            'Show all galleries!',
            GalleryResource::collection($galleries)
        );
    }

    /**
     * Show single gallery by given id
     * 
     * @param id $galleryId
     * @return type
     */
    public function show($galleryId)
    {
        $gallery = Gallery::findOrFail($galleryId);

        if ($gallery->images->isEmpty()) {
            return JsonService::jsonError(
                'There is no images in this gallery!',
                404
            );
        }

        return JsonService::jsonSuccess(
           'Returning gallery and gallery images!',
            GalleryResource::make($gallery)
        );
    }

    /**
     * Shows the view with the form to create new gallery
     * 
     * @return type
     */
    public function showUploadedImages()
    {
        //add pagination
        $userfiles = File::where('user_id', auth()->id())->get();
        if ($userfiles->isEmpty()) {
            return JsonService::jsonError(
                'You haven\'t uploaded any files yet. To create a gallery start by uploading some images.',
                404
            );
        }
        $userImages = $this->imageService->getMultipleImages($userfiles);

        return JsonService::jsonSuccess(
            'Show all Images that the user has uploaded!',
            $userImages->image
        );
    }

    /**
     * Add images to gallery
     * 
     * @param AddToGalleryRequest $request
     * @return type
     */
    public function addToGallery(AddToGalleryRequest $request)
    {
        foreach ($request->images as $imageId) {
            Image::create([
                'gallery_id' => $request->get('galleryId'),
                'file_id' => $imageId
            ]);
        }

        return JsonService::jsonSuccess('Images were added to the Gallery successfully!', []);
    }

    /**
     * Creates new gallery
     * 
     * @param StoreGallery $request
     * @return type
     */
    public function store(StoreGallery $request)
    {
        $galleryId = Gallery::create([
            'name' => $request->galleryName,
            'user_id' => auth()->id()
        ])->id;

        return JsonService::jsonSuccess(
            'New Gallery was added successfully!', [
                'id' => $galleryId,
                'userId' => auth()->id(),
            ]
        );
    }

    /**
     * Delete file from gallery
     * 
     * @param Request $request
     * @param integer $fileId
     * @return type
     */
    public function destroy(Request $request, $fileId)
    {
        $image = Image::where('file_id', $fileId);
        $image->delete();

        return redirect()->back()
            ->with('status', 'Image was deleted from this gallery!');
    }
}
