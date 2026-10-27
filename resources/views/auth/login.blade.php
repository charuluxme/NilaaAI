<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Nilaa AI</title>
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
                <p class="text-gray-600 text-lg">Welcome back! Sign in to continue</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

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
                            autocomplete="current-password" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input 
                                id="remember" 
                                name="remember" 
                                type="checkbox"
                                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-purple-600 hover:text-purple-500">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Sign In
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

                    <!-- Register Link -->
                    <div class="text-center">
                        <p class="text-gray-600">
                            Don't have an account? 
                            <a href="{{ route('register') }}" class="font-semibold text-purple-600 hover:text-purple-500">
                                Sign up for free
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
        </div>
    </div>
</body>
</html>
