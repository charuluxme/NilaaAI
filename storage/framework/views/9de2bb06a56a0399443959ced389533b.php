<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - Nilaa AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom Scrollbar Styles for Webkit browsers (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #9333ea 0%, #db2777 50%, #2563eb 100%);
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #7e22ce 0%, #be185d 50%, #1d4ed8 100%);
        }

        /* Scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(139, 92, 246, 0.1);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(219, 39, 119, 0.5);
            border-radius: 10px;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(219, 39, 119, 0.7);
        }

        /* Firefox scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: #9333ea #f1f5f9;
        }
    </style>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-purple-900 via-purple-800 to-purple-900 text-white transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-purple-700">
                    <a href="/" class="flex items-center">
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-pink-400 to-blue-400 bg-clip-text text-transparent">
                            Nilaa AI
                        </span>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 overflow-y-auto sidebar-scroll">
                    <div class="space-y-2">
                        <a href="/dashboard" class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-700 transition <?php echo e(request()->is('dashboard') ? 'bg-purple-700' : ''); ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>

                        <a href="/upload" class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-700 transition <?php echo e(request()->is('upload') ? 'bg-purple-700' : ''); ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <span>Upload Resume</span>
                        </a>

                        <a href="/resumes" class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-700 transition <?php echo e(request()->is('resumes') ? 'bg-purple-700' : ''); ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span>My Resumes</span>
                        </a>

                        <a href="/interviews" class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-700 transition <?php echo e(request()->is('interviews') ? 'bg-purple-700' : ''); ?>">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <span>Interview Practice</span>
                        </a>

                        <?php if(Auth::user()->isAdmin()): ?>
                        <div class="pt-4 mt-4 border-t border-purple-700">
                            <p class="px-4 text-xs font-semibold text-purple-300 uppercase mb-2">Admin</p>
                            <a href="/admin/users" class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-700 transition <?php echo e(request()->is('admin/users') ? 'bg-purple-700' : ''); ?>">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <span>Manage Users</span>
                            </a>
                            <a href="/admin/analytics" class="flex items-center px-4 py-3 rounded-lg hover:bg-purple-700 transition <?php echo e(request()->is('admin/analytics') ? 'bg-purple-700' : ''); ?>">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 002 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span>Analytics</span>
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </nav>

                <!-- User Profile in Sidebar -->
                <div class="p-4 border-t border-purple-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                            <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-purple-300"><?php echo e(Auth::user()->role); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 z-10">
                <div class="flex items-center justify-between h-16 px-4 lg:px-8">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Page Title -->
                    <h1 class="text-xl font-semibold text-gray-900 hidden lg:block"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>

                    <!-- Right Side -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg py-2 z-20">
                                <div class="px-4 py-2 border-b border-gray-200">
                                    <p class="font-semibold text-gray-900">Notifications</p>
                                </div>
                                <div class="max-h-96 overflow-y-auto">
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                        <p class="text-sm font-medium text-gray-900">Resume analysis complete</p>
                                        <p class="text-xs text-gray-500 mt-1">Your resume scored 85/100</p>
                                        <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                    </a>
                                    <a href="#" class="block px-4 py-3 hover:bg-gray-50">
                                        <p class="text-sm font-medium text-gray-900">New interview questions available</p>
                                        <p class="text-xs text-gray-500 mt-1">Practice for Software Engineer role</p>
                                        <p class="text-xs text-gray-400 mt-1">5 hours ago</p>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold">
                                    <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-sm font-medium text-gray-900"><?php echo e(Auth::user()->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(ucfirst(Auth::user()->role)); ?></p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-20">
                                <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    My Profile
                                </a>
                                <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Settings
                                </a>
                                <hr class="my-2">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-100">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\Nilaa\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>