<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display all users
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter by role
        if ($request->has('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->withCount('resumes')
            ->latest()
            ->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Display a single user
     */
    public function show(User $user)
    {
        $user->load(['resumes.analysis', 'resumes.interviewSessions']);
        
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);
        
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }
        
        $user->update(['role' => $request->role]);
        
        return back()->with('success', 'User role updated successfully.');
    }
    
    /**
     * Delete a user
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
