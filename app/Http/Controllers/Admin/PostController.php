<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{   
    /**
     * Get all post
     * 
     * @return type
     */
    public function index()
    {
        $posts = Post::all()->sortByDesc('id');
        return view('admin/all_posts', compact('posts'));
    }
    
    /**
     * Show post by given id
     * 
     * @param integer $postId
     * @return type
     */
    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        return view('admin/post', compact('post'));
    }
    
    /**
     * Show the edit form of a post with given id
     * 
     * @param integer $postId
     * @return type
     */
    public function edit($postId)
    {
        $post = Post::findOrFail($postId);
        return view('admin/post_edit', compact('post'));
    }
    
    /**
     * Update post
     * 
     * @param Request $request
     * @param integer $postId
     * @return type
     */
    public function update(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $request->validate([
            'title' => 'required,id,'.$postId.',|max:255',
            'content' => 'required,id,'.$postId,
        ]);
        
        $post->title = $request->postTitle;
        $post->content = $request->postContent;
        $post->user_id = Auth::id();
        $post->save();
        
        return redirect('/admin/posts/'.$postId.'/edit')
            ->with('status','Post successfully edit');
    }
}
