<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $permishionsAdmin =  [
        'edit all posts',
        'edit all comments',
        'edit all users',
    ];
    
    private $permishionsModerator =  [
        'edit all posts',
        'edit all comments',
    ];
     
    private $permishionsUser =  [
        'edit own posts',
        'edit own comments',
        'edit profile',
    ];
    
    /**
     * 
     */
    public function creteRole($permisshions, $guard, $name)
    {
        $role = Role::create(['guard_name' => $guard,'name' => $name]);
        
        foreach ($permisshions as $permission) {
            $permissionForRole = Permission::create(['guard_name' => $guard,'name' => $permission]);
            $role->givePermissionTo($permissionForRole);
        }
    }
    
    public function addAllroles()
    {
        $this->addAdminRole();
        $this->addModeratorRole();
        $this->addUserRole();
    }
    
    public function addAdminRole()
    {
        $this->creteRole($this->permishionsAdmin, 'web', 'admin');
    }
    
    public function addModeratorRole()
    {
        $this->creteRole($this->permishionsModerator, 'web', 'moderator');
    }
    
    public function addUserRole()
    {
        $this->creteRole($this->permishionsUser, 'web', 'user');
    }
    
}
