<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->select(['id', 'name', 'email', 'phone', 'status', 'created_at']);

            return DataTables::of($users, $request)
                ->addIndexColumn()
                ->addColumn('avatar', function ($user) {
                    return '<div class="avatar avatar-sm me-2">
                        <img src="' . $user->avatar . '" alt="Avatar" class="rounded-circle">
                    </div>';
                })
                ->addColumn('roles', function ($user) {
                    $roles = '';
                    foreach ($user->roles as $role) {
                        $roles .= '<span class="badge bg-primary me-1">' . ucfirst(str_replace('_', ' ', $role->name)) . '</span>';
                    }
                    return $roles ?: '<span class="text-muted">No roles</span>';
                })
                ->addColumn('status_badge', function ($user) {
                    $badgeClass = $user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary');
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($user->status) . '</span>';
                })
                ->addColumn('actions', function ($user) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('admin.users.show', $user) . '">
                                <i class="ri-eye-line me-1"></i> View
                            </a>
                            <a class="dropdown-item" href="' . route('admin.users.edit', $user) . '">
                                <i class="ri-pencil-line me-1"></i> Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="' . route('admin.users.destroy', $user) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure?\')">
                                    <i class="ri-delete-bin-line me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->setSearchableColumns(['name', 'email', 'phone'])
                ->setOrderableColumns(['id', 'name', 'email', 'created_at'])
                ->rawColumns(['avatar', 'roles', 'status_badge', 'actions'])
                ->make();
        }

        return view('admin.users.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'status' => 'active',
        ]);

        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles', 'profile', 'therapistProfile');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function suspend(User $user)
    {
        $user->update(['status' => 'suspended']);
        return redirect()->back()
            ->with('success', 'User suspended successfully.');
    }

    public function activate(User $user)
    {
        $user->update(['status' => 'active']);
        return redirect()->back()
            ->with('success', 'User activated successfully.');
    }
}
