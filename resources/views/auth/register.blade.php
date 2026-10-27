<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Nilaa AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <!-- Logo & Header -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <h1 class="text-5xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent mb-2">
                        Nilaa AI
                    </h1>
                </a>
                <p class="text-gray-600 text-lg">Create your account and get started</p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            autocomplete="name" 
                            required 
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('name') border-red-500 @enderror"
                            placeholder="John Doe"
                        >
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('email') border-red-500 @enderror"
                            placeholder="you@example.com"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Confirm Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="flex items-start">
                        <input 
                            id="terms" 
                            name="terms" 
                            type="checkbox"
                            required
                            class="h-4 w-4 mt-1 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                        >
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the 
                            <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Terms of Service</a> 
                            and 
                            <a href="#" class="text-purple-600 hover:text-purple-500 font-medium">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Create Account
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-gray-500">or</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Already have an account? 
                            <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-purple-500">
                                Sign in
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="/" class="text-sm text-gray-600 hover:text-gray-900">
                    ← Back to Home
                </a>
            </div>

            <!-- Features -->
            <div class="mt-8 bg-white bg-opacity-60 backdrop-blur rounded-xl p-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">What you'll get:</p>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        AI-powered resume analysis
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Personalized interview practice
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Instant feedback & insights
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
