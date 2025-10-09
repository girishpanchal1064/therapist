<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        $roles = Role::all();
        return view('admin.user-roles.index', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Invalid role selected.');
        }

        $user->assignRole($request->role);

        return redirect()->back()
            ->with('success', 'Role assigned successfully.');
    }

    public function removeRole(User $user, Role $role)
    {
        $user->removeRole($role);

        return redirect()->back()
            ->with('success', 'Role removed successfully.');
    }

    public function syncRoles(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'Invalid roles selected.');
        }

        $user->syncRoles($request->roles ?? []);

        return redirect()->back()
            ->with('success', 'User roles updated successfully.');
    }
}
