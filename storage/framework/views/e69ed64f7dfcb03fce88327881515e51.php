

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 rounded-xl shadow-lg p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">
                            Welcome back, <?php echo e(Auth::user()->name); ?>! 👋
                        </h1>
                        <p class="text-purple-100">Here's your resume analysis overview</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Resumes Uploaded</p>
                            <p class="text-3xl font-bold text-purple-600">3</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Avg ATS Score</p>
                            <p class="text-3xl font-bold text-pink-600">82</p>
                        </div>
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0h2a2 2 0 012 2v6a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Interviews Done</p>
                            <p class="text-3xl font-bold text-blue-600">2</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Resumes -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Recent Resumes</h2>
                        <a href="/upload" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                            Upload New →
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">Senior_Developer_Resume.pdf</h3>
                                    <p class="text-sm text-gray-600 mt-1">Uploaded 2 days ago</p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">ATS: 85</span>
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Analyzed</span>
                                    </div>
                                </div>
                                <a href="/feedback/1" class="text-purple-600 hover:text-purple-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">Backend_Engineer_CV.pdf</h3>
                                    <p class="text-sm text-gray-600 mt-1">Uploaded 5 days ago</p>
                                    <div class="flex items-center gap-4 mt-2">
                                        <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">ATS: 78</span>
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Analyzed</span>
                                    </div>
                                </div>
                                <a href="/feedback/2" class="text-purple-600 hover:text-purple-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Quick Actions</h2>
                    
                    <div class="space-y-3">
                        <a href="/upload" class="block p-4 border-2 border-purple-200 rounded-lg hover:border-purple-400 hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Upload New Resume</h3>
                                    <p class="text-sm text-gray-600">Get instant AI analysis</p>
                                </div>
                            </div>
                        </a>

                        <a href="/interview/1" class="block p-4 border-2 border-pink-200 rounded-lg hover:border-pink-400 hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-pink-600 to-blue-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Practice Interview</h3>
                                    <p class="text-sm text-gray-600">AI-powered mock interviews</p>
                                </div>
                            </div>
                        </a>

                        <a href="/profile" class="block p-4 border-2 border-blue-200 rounded-lg hover:border-blue-400 hover:shadow-md transition">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">Update Profile</h3>
                                    <p class="text-sm text-gray-600">Manage your account settings</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nilaa\resources\views/dashboard.blade.php ENDPATH**/ ?>