<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Arr;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        if ($request->wantsJson()) {
            return response()->json([
                'users' => $users,
                'roles' => $roles,
            ]);
        }

        return view('roles.users', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
  
    
    public function update(Request $request, User $user)
    {
        $roles = Arr::wrap($request->roles); // تأكد أنها مصفوفة
    
        // تأكد أن كل دور موجود وله guard = 'web'
        foreach ($roles as $roleName) {
            Role::findOrCreate($roleName, 'web');
        }
    
        // طبق الأدوار
        $user->syncRoles($roles);
    
        // امسح الكاش لضمان التحديث
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    
        return response()->json([
            'message' => 'User roles updated.',
            'roles' => $user->getRoleNames(),
        ]);
    }
    
}
