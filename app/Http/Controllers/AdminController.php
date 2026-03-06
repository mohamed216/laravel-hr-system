<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'hrs' => User::where('role', 'hr')->count(),
            'employees' => User::where('role', 'employee')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::with('employee')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users-create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,hr,employee',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users')->with('success', __('created_successfully'));
    }

    public function editUser(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users-edit', compact('user'));
    }

    public function updateUser(Request $request, int $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,hr,employee',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users')->with('success', __('updated_successfully'));
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', __('You cannot delete yourself'));
        }
        
        $user->delete();

        return redirect()->route('admin.users')->with('success', __('deleted_successfully'));
    }
}
