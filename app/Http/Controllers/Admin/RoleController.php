<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Facades\DataTables;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::with(['permissions', 'users'])->select(['id', 'name', 'created_at']);

            return DataTables::of($roles, $request)
                ->addIndexColumn()
                ->addColumn('role_name', function ($role) {
                    $isCore = in_array($role->name, ['super_admin', 'admin', 'therapist', 'client']);
                    $coreBadge = $isCore ? '<small class="text-muted">Core Role</small>' : '';

                    return '<div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded bg-primary">' . strtoupper(substr($role->name, 0, 2)) . '</span>
                        </div>
                        <div>
                            <h6 class="mb-0">' . ucfirst(str_replace('_', ' ', $role->name)) . '</h6>
                            ' . $coreBadge . '
                        </div>
                    </div>';
                })
                ->addColumn('permissions_count', function ($role) {
                    return '<span class="badge bg-info">' . $role->permissions->count() . '</span>';
                })
                ->addColumn('users_count', function ($role) {
                    return '<span class="badge bg-secondary">' . $role->users->count() . '</span>';
                })
                ->addColumn('actions', function ($role) {
                    $isCore = in_array($role->name, ['super_admin', 'admin', 'therapist', 'client']);
                    $deleteButton = '';

                    if (!$isCore) {
                        $deleteButton = '<div class="dropdown-divider"></div>
                            <form action="' . route('admin.roles.destroy', $role) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure you want to delete this role?\')">
                                    <i class="ri-delete-bin-line me-1"></i> Delete
                                </button>
                            </form>';
                    }

                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('admin.roles.show', $role) . '">
                                <i class="ri-eye-line me-1"></i> View
                            </a>
                            <a class="dropdown-item" href="' . route('admin.roles.edit', $role) . '">
                                <i class="ri-pencil-line me-1"></i> Edit
                            </a>
                            ' . $deleteButton . '
                        </div>
                    </div>';
                })
                ->setSearchableColumns(['name'])
                ->setOrderableColumns(['id', 'name', 'created_at'])
                ->rawColumns(['role_name', 'permissions_count', 'users_count', 'actions'])
                ->make();
        }

        return view('admin.roles.index');
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[0]; // Group by first word (e.g., 'view', 'create', 'edit')
        });
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode(' ', $permission->name)[0];
        });
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        // Prevent deletion of core roles
        if (in_array($role->name, ['super_admin', 'admin', 'therapist', 'client'])) {
            return redirect()->back()
                ->with('error', 'Cannot delete core system roles.');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
