

<?php $__env->startSection('title', 'Settings'); ?>
<?php $__env->startSection('page-title', 'Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-bold mb-4">Application Settings</h2>

        <p class="text-gray-700 mb-4">This page is a friendly UI placeholder for runtime settings. Some settings (like pdftotext path and OpenAI API keys) are stored in environment configuration and must be updated in your <code>.env</code> file or server config.</p>

        <div class="space-y-4">
            <div class="p-4 border rounded">
                <h3 class="font-semibold">PDF Parser</h3>
                <p class="text-sm text-gray-600">If parsing fails on Windows, install <code>pdftotext</code> (poppler) and set <code>PARSER_PDFTOTEXT_PATH</code> in your <code>.env</code>. The app will attempt to auto-detect it.</p>
            </div>

            <div class="p-4 border rounded">
                <h3 class="font-semibold">OpenAI / LLM</h3>
                <p class="text-sm text-gray-600">OpenAI API key and model are configured via <code>.env</code> and <code>config/openai.php</code>. Keep your key secret.</p>
            </div>

            <div class="p-4 border rounded">
                <h3 class="font-semibold">Diagnostics</h3>
                <p class="text-sm text-gray-600">You can re-run parsing for any resume from the Resumes list. Use the "Reanalyze" action to dispatch the parsing job again.</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Nilaa\resources\views/settings.blade.php ENDPATH**/ ?>