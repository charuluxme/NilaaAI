@extends('layouts.dashboard')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Your Profile</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="flex items-center justify-center">
                <div class="w-28 h-28 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>

            <div class="md:col-span-2">
                <p class="text-lg font-semibold">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                <p class="mt-4 text-gray-700">Role: <span class="font-medium">{{ ucfirst(Auth::user()->role) }}</span></p>

                <div class="mt-6">
                    <a href="/settings" class="inline-block bg-purple-600 text-white px-4 py-2 rounded-md">Edit Settings</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
