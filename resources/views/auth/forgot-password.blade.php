<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - Nilaa AI</title>
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
                <p class="text-gray-600 text-lg">Reset your password</p>
            </div>

            <!-- Forgot Password Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <div class="mb-4 text-sm text-gray-600">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                </div>

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white font-bold py-3 px-4 rounded-lg hover:opacity-90 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        Email Password Reset Link
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-sm text-purple-600 hover:text-purple-500">
                            ← Back to login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
