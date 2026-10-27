

<?php $__env->startSection('title', 'My Resumes'); ?>
<?php $__env->startSection('page-title', 'My Resumes'); ?>

<?php $__env->startSection('content'); ?>
    <div class="p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">My Resumes</h2>
                <a href="/upload" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                    Upload New Resume
                </a>
            </div>

            <?php if($resumes->isEmpty()): ?>
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No resumes yet</h3>
                    <p class="text-gray-600 mb-6">Upload your first resume to get started</p>
                    <a href="/upload" class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white px-8 py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        Upload Resume
                    </a>
                </div>
            <?php else: ?>
                <div class="grid gap-6">
                    <?php $__currentLoopData = $resumes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resume): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($resume->original_filename); ?></h3>
                                    <p class="text-sm text-gray-600 mb-4">
                                        Uploaded <?php echo e($resume->uploaded_at->diffForHumans()); ?>

                                    </p>
                                    
                                    <div class="flex flex-wrap gap-3 mb-4">
                                        <?php if($resume->analysis): ?>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                                ATS Score: <?php echo e($resume->analysis->ats_score); ?>/100
                                            </span>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                                Analyzed
                                            </span>
                                        <?php else: ?>
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                                Processing...
                                            </span>
                                        <?php endif; ?>
                                        
                                        <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                            <?php echo e(number_format($resume->size_bytes / 1024, 1)); ?> KB
                                        </span>
                                    </div>

                                    <?php if($resume->skillTags->isNotEmpty()): ?>
                                        <div class="flex flex-wrap gap-2">
                                            <?php $__currentLoopData = $resume->skillTags->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs">
                                                    <?php echo e($skill->canonical_name); ?>

                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($resume->skillTags->count() > 5): ?>
                                                <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs">
                                                    +<?php echo e($resume->skillTags->count() - 5); ?> more
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="flex flex-col gap-2 ml-4">
                                    <?php if($resume->analysis): ?>
                                        <a href="/feedback/<?php echo e($resume->id); ?>" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-medium text-center">
                                            View Analysis
                                        </a>
                                        <a href="/interview/<?php echo e($resume->id); ?>" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition text-sm font-medium text-center">
                                            Start Interview
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="mt-6">
                    <?php echo e($resumes->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nilaa\resources\views/resumes/index.blade.php ENDPATH**/ ?>