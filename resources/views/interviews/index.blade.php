@extends('layouts.dashboard')

@section('title', 'Interview Sessions')
@section('page-title', 'Interview Sessions')

@section('content')
    <div class="p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Interview Practice Sessions</h2>
                <p class="text-gray-600">Review your past interview performances</p>
            </div>

            @if($sessions->isEmpty())
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No interview sessions yet</h3>
                    <p class="text-gray-600 mb-6">Upload a resume and start practicing</p>
                    <a href="/upload" class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        Upload Resume
                    </a>
                </div>
            @else
                <div class="grid gap-6">
                    @foreach($sessions as $session)
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">{{ $session->role_applied }}</h3>
                                    <p class="text-sm text-gray-600">
                                        Started {{ $session->started_at->diffForHumans() }}
                                        @if($session->completed_at)
                                            • Completed {{ $session->completed_at->diffForHumans() }}
                                        @endif
                                    </p>
                                </div>
                                @if($session->overall_score)
                                    <div class="text-right">
                                        <p class="text-3xl font-bold text-purple-600">{{ $session->overall_score }}</p>
                                        <p class="text-sm text-gray-600">Overall Score</p>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center gap-4 mb-4">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $session->questions->count() }} Questions
                                </span>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    {{ $session->questions->filter(fn($q) => $q->answer)->count() }} Answered
                                </span>
                                @if($session->completed_at)
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                        In Progress
                                    </span>
                                @endif
                            </div>

                            <div class="flex gap-3">
                                <a href="/interview/{{ $session->resume_id }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium">
                                    {{ $session->completed_at ? 'Review' : 'Continue' }}
                                </a>
                                <a href="/feedback/{{ $session->resume_id }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                                    View Resume Analysis
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $sessions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
