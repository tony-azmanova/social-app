<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/semi-spa/home', 'HomeController@index')->middleware('auth');
Route::get('/semi-spa/walls', 'HomeController@index')->name('semi-spa.home')->middleware('auth');
Route::get('/semi-spa/posts/{id}', 'HomeController@index')->middleware('auth');
Route::get('/semi-spa/walls/{userId}', 'HomeController@index')->middleware('auth');
Route::get('/semi-spa/user-wall', 'HomeController@index')->middleware('auth');
Route::get('/semi-spa/user-wall/{userId}', 'HomeController@index')->middleware('auth');

Route::get('/semi-spa/users/search','UserController@search')->middleware('auth');
Route::get('/semi-spa/my-profile','HomeController@index')->middleware('auth');
Route::get('/semi-spa/files/upload','HomeController@index')->middleware('auth');
Route::get('/semi-spa/galleries/{galleryid}', 'HomeController@index')->name('galleries.show')->middleware('auth');
Route::get('/semi-spa/galleries','HomeController@index')->middleware('auth');
Route::get('/semi-spa/galleries/new','HomeController@index')->middleware('auth');
Route::get('/semi-spa/notifications','HomeController@index')->middleware('auth');
Route::get('/semi-spa/my-friends','HomeController@index')->middleware('auth');

//laravel routes
Route::get('/userWall', 'WallController@index')->name('user.wall')->middleware('auth');
Route::get('/userWall/{userId}', 'WallController@show')->middleware('auth');

Route::get('/posts', 'PostController@index')->middleware('auth');
Route::post('/posts', 'PostController@store')->middleware('auth');
Route::get('/posts/{postId}','PostController@show')->middleware('auth');

Route::get('/users/search','UserController@search')->middleware('auth');
Route::get('/users/{userId}','UserController@show')->name('user.profile')->middleware('auth');

Route::get('/users/{userId}/addFriend','FriendsController@addFriend')->middleware('auth');
Route::post('/users/friend/accept/{notificationId}', 'FriendsController@acceptFriendRequest')->middleware('auth');
Route::post('/users/friend/cancel/{notificationId}', 'FriendsController@cancelFriendRequest')->middleware('auth');
Route::get('/users/{userId}/avatar', 'UserController@getAvatarOfUser')->middleware('auth');

Route::get('/friends', 'FriendsController@show')->name('user.friends')->middleware('auth');
Route::get('/friends/status/{userId}', 'FriendsController@friendshipStatus')->middleware('auth');
Route::get('/notifications', 'NotificationController@index')->name('user.notifications')->middleware('auth');
Route::post('/notifications', 'FriendsController@userNotifications')->middleware('auth');

Route::post('/posts/{postId}/comment', 'CommentController@store')->middleware('auth');
Route::post('/posts/react', 'ReactionController@create')->middleware('auth');

Route::post('/comments/react', 'ReactionController@create')->middleware('auth');
Route::post('/comments/post/{postId}', 'PostController@postComment')->middleware('auth');
Route::get('/comments/post/{postId}', 'PostController@postComment')->middleware('auth');

Route::get('/files', 'FileController@index')->name('files.index')->middleware('auth');
Route::post('/files/upload', 'FileController@store')->middleware('auth');
Route::delete('/files/{fileId}', 'FileController@destroy')->name('files.delete')->middleware('auth');
Route::post('/avatar/upload', 'FileController@storeAvatar')->middleware('auth');

Route::get('/galleries', 'GalleryController@index')->name('galleries.index');
Route::post('/galleries', 'GalleryController@store')->middleware('auth');
Route::post('/galleries/create', 'GalleryController@showUploadedImages')->middleware('auth');
Route::get('/galleries/create', 'GalleryController@showUploadedImages')->name('galleries.create')->middleware('auth');
Route::post('/galleries/addToGallery', 'GalleryController@addToGallery');
Route::get('/galleries/{galleryId}', 'GalleryController@show')->middleware('auth');
Route::put('/galleries/{galleryid}', 'GalleryController@update')->middleware('auth');
Route::delete('/galleries/{fileId}', 'GalleryController@destroy')->name('galleries.image.remove')->middleware('auth');

Route::middleware(['admin'])->group(function () {
    Route::get('/admin','Admin\AdminController@index');
    
    Route::get('/admin/users','Admin\UserController@index');
    Route::get('/admin/users/{userId}','Admin\UserController@show');
    Route::get('/admin/users/{userId}/edit','Admin\UserController@edit');
    Route::post('/admin/users/{userId}/edit','Admin\UserController@update');
    
    Route::get('/admin/posts','Admin\PostController@index');
    Route::get('/admin/posts/{postId}','Admin\PostController@show');
    Route::get('/admin/posts/{postId}/edit','Admin\PostController@edit');
    Route::post('/admin/posts/{postId}/edit','Admin\PostController@update');
});
