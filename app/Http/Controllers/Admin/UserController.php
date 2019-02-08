<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\User;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = User::all()->sortByDesc('id');
        return view('admin/all_users', compact('users'));
    }
    
    public function show($userId)
    {
        $user = User::findOrFail($userId);
        $roles =  $user->getRoleNames();
        
        return view('admin/user_profile', compact('user','roles'));
    }
    
    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $roles = Role::all();

        return view('admin/user_profile_edit', compact('user', 'roles'));
    }
    
    public function update(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|unique:users,id,'.$user->id,
            'roles' => 'required|exists:roles,id'
        ]);
        
        $this->store($user);
        
        return redirect('/admin/users/'.$userId.'/edit')
            ->with('status','User successfully edit');
    }
    
    public function store($user)
    {
        $user->first_name = request()->first_name;
        $user->last_name = request()->last_name;
        $user->email = request()->email;
        $user->roles()->sync(request()->roles); 
        $user->save();
        
    }
    
}
