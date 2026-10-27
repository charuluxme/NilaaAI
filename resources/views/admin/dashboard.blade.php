@extends('layouts.dashboard')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h2>
                <p class="text-gray-600">System overview and statistics</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Users</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $stats['total_users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['total_admins'] }} admins</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Resumes</p>
                            <p class="text-3xl font-bold text-pink-600">{{ $stats['total_resumes'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['resumes_today'] }} today</p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Interview Sessions</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $stats['total_interviews'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">Avg ATS: {{ number_format($stats['avg_ats_score'], 1) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Recent Users -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Recent Users</h3>
                        <a href="/admin/users" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                            View All →
                        </a>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($recentUsers as $user)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <span class="px-2 py-1 {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }} rounded text-xs">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Resumes -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Recent Resumes</h3>
                        <a href="/admin/analytics" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                            Analytics →
                        </a>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($recentResumes->take(5) as $resume)
                            <div class="p-3 hover:bg-gray-50 rounded-lg">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900 text-sm">{{ Str::limit($resume->original_filename, 30) }}</p>
                                        <p class="text-xs text-gray-500">{{ $resume->user->name }} • {{ $resume->uploaded_at->diffForHumans() }}</p>
                                    </div>
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                        {{ ucfirst($resume->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
