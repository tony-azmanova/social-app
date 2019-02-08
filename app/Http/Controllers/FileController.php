<?php

namespace App\Http\Controllers;

use App\User;
use App\File;
use App\Image;
use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\ImageService;
use App\Http\Requests\AddFileRequest;

class FileController extends Controller
{
    protected $imageService;
    
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }
    
    /**
     * Upload file
     */
    public function index()
    {
    }

    /**
     * Stores the files to db and to system
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'uploadedFile' => 'required|mimes:jpeg,png,jpg'
        ]);
        
        $file = $request->file('uploadedFile');
        
        if (!$file->isValid()) {
            return JsonService::jsonError('Sorry! The file was not uploadded!');
        }

        $filePath = $file->store('/files/images', 'public');
        $this->imageService->createThumbnails($filePath, [200, 500, 800]);
        $fileId = File::create([
            'originalName' => $file->getClientOriginalName(),
            'pathToFile' => $filePath,
            'mimeType' => $file->getClientMimeType(),
            'user_id' => auth()->id(),
        ])->id;
 
        return JsonService::jsonSuccess(
            'File was uploaded successfully',
            $this->imageService->getInfoForImage(File::findOrFail($fileId))
        );
    }
    
    /**
     * Store user avatar
     * 
     * @param AddFileRequest $request
     * @return type
     */
    public function storeAvatar(AddFileRequest $request)
    {
        $validated = $request->validated();

        if (!$validated) {
            return JsonService::jsonError($validated->errors()->first());
        }

        $file = $request->file('uploadedFile');

        $filePath = $file->store('/files/images/avatars/'.auth()->id(), 'public');
        $this->imageService->createThumbnails($filePath, [50, 200]);

        $fileId = File::create([
            'originalName' => $file->getClientOriginalName(),
            'pathToFile' => $filePath,
            'mimeType' => $file->getClientMimeType(),
            'user_id' => auth()->id(),
        ])->id;

        $user = User::findOrfail(auth()->id());
        $user->avatar_file_id = $fileId;
        $user->save();

        return JsonService::jsonSuccess(
            'User avatar was uploaded successfully!',
            $this->imageService->getInfoForImage(File::findOrFail($fileId))
        );
    }

    /**
     * Delete file
     * 
     * @param Request $request
     * @param integer $fileId
     * @return type
     */
    public function destroy(Request $request, $fileId)
    {   
        $file = File::findOrFail($fileId);
        
        $this->imageService->deleteImage($file->pathToFile);
        $image = Image::where('file_id', $fileId)->delete();
        $deleted = File::destroy($fileId);

        if (!$deleted) {
            return JsonService::jsonError('Sorry! The file was not Deleted!');
        }
        return JsonService::jsonSuccess('File was deleted!', boolval($deleted));
    }
}
