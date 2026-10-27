@extends('layouts.dashboard')

@section('title', 'Analytics')
@section('page-title', 'Analytics')

@section('content')
    <div class="p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Analytics Dashboard</h2>
                <p class="text-gray-600">Platform usage statistics and trends</p>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        +{{ \App\Models\User::whereDate('created_at', today())->count() }} today
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Total Resumes</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Resume::count() }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        +{{ \App\Models\Resume::whereDate('uploaded_at', today())->count() }} today
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Interview Sessions</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\InterviewSession::count() }}</p>
                    <p class="text-xs text-green-600 mt-1">
                        +{{ \App\Models\InterviewSession::whereDate('started_at', today())->count() }} today
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 002 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600">Avg ATS Score</p>
                    <p class="text-3xl font-bold text-gray-900">
                        {{ number_format(\App\Models\ResumeAnalysis::avg('ats_score') ?? 0, 1) }}
                    </p>
                    <p class="text-xs text-gray-500 mt-1">out of 100</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 mb-8">
                <!-- User Growth Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">User Growth (Last 30 Days)</h3>
                    
                    @if($userGrowth->isNotEmpty())
                        <div class="space-y-3">
                            @foreach($userGrowth->reverse() as $item)
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</span>
                                            <span class="text-sm font-bold text-purple-600">{{ $item->count }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-gradient-to-r from-purple-600 to-pink-600 h-2 rounded-full" 
                                                 style="width: {{ min(($item->count / $userGrowth->max('count')) * 100, 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No user data available</p>
                    @endif
                </div>

                <!-- Resume Status Distribution -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Resume Status Distribution</h3>
                    
                    @if($resumeStats->isNotEmpty())
                        <div class="space-y-4">
                            @php
                                $totalResumes = $resumeStats->sum('count');
                                $statusColors = [
                                    'uploaded' => ['bg' => 'bg-blue-600', 'text' => 'text-blue-600'],
                                    'processing' => ['bg' => 'bg-yellow-600', 'text' => 'text-yellow-600'],
                                    'analyzed' => ['bg' => 'bg-green-600', 'text' => 'text-green-600'],
                                    'failed' => ['bg' => 'bg-red-600', 'text' => 'text-red-600'],
                                ];
                            @endphp
                            
                            @foreach($resumeStats as $stat)
                                @php
                                    $percentage = $totalResumes > 0 ? ($stat->count / $totalResumes) * 100 : 0;
                                    $color = $statusColors[$stat->status] ?? ['bg' => 'bg-gray-600', 'text' => 'text-gray-600'];
                                @endphp
                                
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <span class="w-3 h-3 rounded-full {{ $color['bg'] }} mr-2"></span>
                                            <span class="text-sm font-medium text-gray-900 capitalize">{{ $stat->status }}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-bold {{ $color['text'] }}">{{ $stat->count }}</span>
                                            <span class="text-xs text-gray-500 ml-1">({{ number_format($percentage, 1) }}%)</span>
                                        </div>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="{{ $color['bg'] }} h-2 rounded-full transition-all" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No resume data available</p>
                    @endif
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900">Recent Activity</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $recentResumes = \App\Models\Resume::with('user')
                                    ->latest('uploaded_at')
                                    ->limit(10)
                                    ->get();
                            @endphp
                            
                            @forelse($recentResumes as $resume)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $resume->uploaded_at->format('M d, Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-xs font-bold mr-2">
                                                {{ substr($resume->user->name ?? 'U', 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-900">{{ $resume->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        Resume Upload: {{ Str::limit($resume->original_filename, 30) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $resume->status === 'analyzed' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $resume->status === 'processing' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $resume->status === 'uploaded' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $resume->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($resume->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                        No recent activity
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
