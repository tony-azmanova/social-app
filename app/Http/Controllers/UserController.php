<?php

namespace App\Http\Controllers;

use App\User;
use App\File;
use Illuminate\Http\Request;
use App\Services\JsonService;
use App\Services\ImageService;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Returns all result from search
     * 
     * @param Request $request
     */
    public function search(Request $request)
    {
        $searchTerm = $request->get('searchTerm');
        $users = UserResource::collection(User::searchUsersBySearchTerm($searchTerm)->get());
        if ($users->isEmpty()) {
            return JsonService::jsonError(
                'There is no users found with this name!',
                404
            );
        }
        return JsonService::jsonSuccess('Returning all for a users!', $users);
    }

    /**
     * Returns a user by given id
     * 
     * @param integer $userId
     */
    public function show($userId)
    {
        return JsonService::jsonSuccess(
            'Returning a user!',
            UserResource::make(User::findOrFail($userId))
        );
    }

    /**
     * Returns an avatar by given user id
     * 
     * @param integer $userId
     */
    public function getAvatarOfUser($userId)
    {
        $user = User::findOrFail($userId);
        $avatarFile = File::find($user->avatar_file_id);
        return JsonService::jsonSuccess(
            'Returning all for a user avatar!',
            $this->imageService->getInfoForImage($avatarFile)
        );
    }
}
