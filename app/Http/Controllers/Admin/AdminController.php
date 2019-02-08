<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\User;
use App\Http\Controllers\Controller;

/**
 * Description of AdminController
 *
 * @author tony
 */
class AdminController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $posts = Post::all();
        $users = User::all();
        return view('admin/admin_home', compact('posts', 'users'));
    }
    
    
    
}
