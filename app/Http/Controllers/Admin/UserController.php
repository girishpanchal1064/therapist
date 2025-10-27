<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            try {
                \Log::info('DataTables AJAX Request', [
                    'request_data' => $request->all(),
                    'user_authenticated' => auth()->check(),
                    'user_id' => auth()->id()
                ]);

                $draw = intval($request->input('draw'));
                $start = intval($request->input('start'));
                $length = intval($request->input('length'));
                $searchValue = $request->input('search.value');
                $orderColumn = intval($request->input('order.0.column'));
                $orderDir = $request->input('order.0.dir', 'asc');

                // Get total records count
                $totalRecords = User::count();
                \Log::info('Total users count: ' . $totalRecords);

                // Build query
                $query = User::with('roles')->select(['id', 'name', 'email', 'phone', 'status', 'avatar', 'created_at']);

                // Apply search
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('name', 'like', "%{$searchValue}%")
                          ->orWhere('email', 'like', "%{$searchValue}%")
                          ->orWhere('phone', 'like', "%{$searchValue}%");
                    });
                }

                // Get filtered count
                $filteredRecords = $query->count();

                // Apply ordering
                $orderColumns = ['id', 'name', 'email', 'created_at'];
                if (isset($orderColumns[$orderColumn])) {
                    $query->orderBy($orderColumns[$orderColumn], $orderDir);
                }

                // Apply pagination
                $users = $query->skip($start)->take($length)->get();

                // Process data
                $data = [];
                foreach ($users as $index => $user) {
                    $data[] = [
                        'DT_RowIndex' => $start + $index + 1,
                        'avatar' => $user->avatar ?
                            '<div class="avatar avatar-sm me-2"><img src="' . asset('storage/' . $user->avatar) . '" alt="Avatar" class="rounded-circle" width="32" height="32"></div>' :
                            '<div class="avatar avatar-sm me-2"><span class="avatar-initial rounded bg-label-primary">' . strtoupper(substr($user->name, 0, 2)) . '</span></div>',
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone ?: '<span class="text-muted">Not set</span>',
                        'roles' => $user->roles->map(function($role) {
                            return '<span class="badge bg-primary me-1">' . ucfirst(str_replace('_', ' ', $role->name)) . '</span>';
                        })->join('') ?: '<span class="text-muted">No roles</span>',
                        'status_badge' => '<span class="badge bg-' . ($user->status === 'active' ? 'success' : ($user->status === 'suspended' ? 'danger' : 'secondary')) . '">' . ucfirst($user->status ?: 'inactive') . '</span>',
                        'created_at' => $user->created_at->format('M d, Y'),
                        'actions' => '<div class="dropdown">
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
                        </div>'
                    ];
                }

                \Log::info('DataTables Response', [
                    'draw' => $draw,
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data_count' => count($data),
                    'first_user' => count($data) > 0 ? $data[0] : null
                ]);

                return response()->json([
                    'draw' => $draw,
                    'recordsTotal' => $totalRecords,
                    'recordsFiltered' => $filteredRecords,
                    'data' => $data
                ]);

            } catch (\Exception $e) {
                \Log::error('DataTables Error: ' . $e->getMessage());
                return response()->json([
                    'draw' => intval($request->input('draw')),
                    'recordsTotal' => 0,
                    'recordsFiltered' => 0,
                    'data' => [],
                    'error' => 'Error loading data: ' . $e->getMessage()
                ]);
            }
        }

        return view('admin.users.index');
    }

    public function create()
    {
        $roles = Role::whereIn('name', ['super_admin', 'admin', 'therapist', 'client'])->orderBy('name')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'status' => $request->status,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create($userData);

        // Assign role
        $role = Role::findById($request->role);
        $user->assignRole($role);

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
        $roles = Role::whereIn('name', ['super_admin', 'admin', 'therapist', 'client'])->orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
        ];

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $userData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($userData);

        // Sync roles
        $user->syncRoles($request->roles);

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
