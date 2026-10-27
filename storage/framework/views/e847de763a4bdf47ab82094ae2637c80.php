<nav class="bg-white shadow-lg border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <span class="text-2xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">
                        Nilaa AI
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8">
                <?php if(auth()->guard()->check()): ?>
                    <a href="/upload" class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition <?php echo e(request()->is('upload') ? 'text-purple-600 font-semibold' : ''); ?>">
                        Upload Resume
                    </a>
                    <a href="/dashboard" class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition <?php echo e(request()->is('dashboard') ? 'text-purple-600 font-semibold' : ''); ?>">
                        Dashboard
                    </a>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-purple-600 focus:outline-none">
                            <div class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white font-semibold">
                                <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                            </div>
                            <span class="text-sm font-medium"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Profile</a>
                            <a href="/settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">Settings</a>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/login" class="text-gray-700 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition">
                        Login
                    </a>
                    <a href="/register" class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition shadow-md">
                        Get Started
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileOpen = !mobileOpen" class="text-gray-700 hover:text-purple-600 focus:outline-none" x-data="{ mobileOpen: false }">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div x-show="mobileOpen" class="md:hidden" x-data="{ mobileOpen: false }">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-gray-50">
            <?php if(auth()->guard()->check()): ?>
                <a href="/upload" class="block text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-3 py-2 rounded-md text-base font-medium">
                    Upload Resume
                </a>
                <a href="/dashboard" class="block text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-3 py-2 rounded-md text-base font-medium">
                    Dashboard
                </a>
                <a href="/profile" class="block text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-3 py-2 rounded-md text-base font-medium">
                    Profile
                </a>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="block w-full text-left text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-3 py-2 rounded-md text-base font-medium">
                        Logout
                    </button>
                </form>
            <?php else: ?>
                <a href="/login" class="block text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-3 py-2 rounded-md text-base font-medium">
                    Login
                </a>
                <a href="/register" class="block text-gray-700 hover:text-purple-600 hover:bg-purple-50 px-3 py-2 rounded-md text-base font-medium">
                    Get Started
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Alpine.js for dropdowns -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<?php /**PATH D:\Projects\Start-Up\Nilaa\resources\views/components/navbar.blade.php ENDPATH**/ ?>