@extends('layouts.dashboard')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
    <div class="p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">User Management</h2>
                    <p class="text-gray-600">Manage user accounts and permissions</p>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
                <form method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Search by name or email..." 
                               value="{{ request('search') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                    </div>
                    <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                        <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Roles</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Users</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                    </select>
                    <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                        Filter
                    </button>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resumes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" onchange="this.form.submit()" 
                                                class="px-3 py-1 border border-gray-300 rounded {{ $user->role === 'admin' ? 'bg-red-50 text-red-800 border-red-300' : 'bg-blue-50 text-blue-800 border-blue-300' }}"
                                                {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $user->resumes_count }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-purple-600 hover:text-purple-900">View</a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                  onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
