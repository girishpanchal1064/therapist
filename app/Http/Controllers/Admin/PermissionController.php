<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Facades\DataTables;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $permissions = Permission::with('roles')->select(['id', 'name', 'description', 'created_at']);

            return DataTables::of($permissions, $request)
                ->addIndexColumn()
                ->addColumn('permission_name', function ($permission) {
                    $firstWord = explode(' ', $permission->name)[0];
                    $initials = strtoupper(substr($firstWord, 0, 2));

                    return '<div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded bg-info">' . $initials . '</span>
                        </div>
                        <div>
                            <h6 class="mb-0">' . ucfirst(str_replace('_', ' ', $permission->name)) . '</h6>
                            <small class="text-muted">' . $permission->name . '</small>
                        </div>
                    </div>';
                })
                ->addColumn('description', function ($permission) {
                    return $permission->description ?: '<span class="text-muted">No description</span>';
                })
                ->addColumn('roles_count', function ($permission) {
                    return '<span class="badge bg-primary">' . $permission->roles->count() . '</span>';
                })
                ->addColumn('actions', function ($permission) {
                    return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="ri-more-2-line"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('admin.permissions.show', $permission) . '">
                                <i class="ri-eye-line me-1"></i> View
                            </a>
                            <a class="dropdown-item" href="' . route('admin.permissions.edit', $permission) . '">
                                <i class="ri-pencil-line me-1"></i> Edit
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="' . route('admin.permissions.destroy', $permission) . '" method="POST" class="d-inline">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure you want to delete this permission?\')">
                                    <i class="ri-delete-bin-line me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>';
                })
                ->setSearchableColumns(['name', 'description'])
                ->setOrderableColumns(['id', 'name', 'created_at'])
                ->rawColumns(['permission_name', 'description', 'roles_count', 'actions'])
                ->make();
        }

        return view('admin.permissions.index');
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.permissions.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission = Permission::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all();
        $permission->load('roles');
        return view('admin.permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $permission->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
