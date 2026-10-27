<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Feedback - Nilaa AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="min-h-screen py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">Resume Analysis & Feedback</h1>
                <p class="mt-2 text-gray-600">AI-powered insights to improve your resume</p>
            </div>

            <!-- Loading State -->
            <div id="loading" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mx-auto"></div>
                <p class="mt-4 text-gray-600">Analyzing your resume...</p>
            </div>

            <!-- Analysis Content -->
            <div id="content" class="hidden space-y-6">
                <!-- Score Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- ATS Score -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">ATS Score</h2>
                        <div class="flex items-center justify-center">
                            <div class="relative w-32 h-32">
                                <svg class="transform -rotate-90 w-32 h-32">
                                    <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="8" fill="none" />
                                    <circle id="atsCircle" cx="64" cy="64" r="56" stroke="#3b82f6" stroke-width="8" fill="none" 
                                            stroke-dasharray="351.86" stroke-dashoffset="351.86" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="atsScore" class="text-3xl font-bold text-gray-900">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Readability Score -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Readability Score</h2>
                        <div class="flex items-center justify-center">
                            <div class="relative w-32 h-32">
                                <svg class="transform -rotate-90 w-32 h-32">
                                    <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="8" fill="none" />
                                    <circle id="readabilityCircle" cx="64" cy="64" r="56" stroke="#10b981" stroke-width="8" fill="none"
                                            stroke-dasharray="351.86" stroke-dashoffset="351.86" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="readabilityScore" class="text-3xl font-bold text-gray-900">0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Detected Skills</h2>
                    <div id="skills" class="flex flex-wrap gap-2"></div>
                </div>

                <!-- Suggestions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Improvement Suggestions</h2>
                    <div id="suggestions" class="space-y-3"></div>
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    <a href="/interview/<?php echo e($resumeId); ?>" class="flex-1 text-center bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white py-3 px-4 rounded-md hover:opacity-90 transition font-semibold shadow-lg">
                        Start Interview Practice
                    </a>
                    <button class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Download PDF Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const resumeId = <?php echo e($resumeId); ?>;

        async function loadAnalysis() {
            try {
                const response = await fetch(`/api/resume/${resumeId}/analysis`);
                const data = await response.json();

                if (response.status === 202) {
                    // Still processing, check again in 3 seconds
                    setTimeout(loadAnalysis, 3000);
                    return;
                }

                if (response.ok) {
                    displayAnalysis(data.analysis);
                }
            } catch (error) {
                console.error('Failed to load analysis:', error);
                setTimeout(loadAnalysis, 3000);
            }
        }

        function displayAnalysis(analysis) {
            document.getElementById('loading').classList.add('hidden');
            document.getElementById('content').classList.remove('hidden');

            // Display ATS Score
            const atsScore = analysis.ats_score || 0;
            document.getElementById('atsScore').textContent = atsScore;
            animateCircle('atsCircle', atsScore);

            // Display Readability Score
            const readabilityScore = Math.round(analysis.readability_score || 0);
            document.getElementById('readabilityScore').textContent = readabilityScore;
            animateCircle('readabilityCircle', readabilityScore);

            // Display Skills
            const skillsHtml = (analysis.skill_tags || []).map(skill => 
                `<span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">${skill}</span>`
            ).join('');
            document.getElementById('skills').innerHTML = skillsHtml || '<p class="text-gray-500">No skills detected</p>';

            // Display Suggestions
            const suggestions = Array.isArray(analysis.suggestions) ? analysis.suggestions : [];
            const suggestionsHtml = suggestions.map((suggestion, index) => {
                if (typeof suggestion === 'string') {
                    return `<div class="flex items-start gap-3">
                        <span class="flex-shrink-0 w-6 h-6 bg-yellow-100 text-yellow-800 rounded-full flex items-center justify-center text-sm">${index + 1}</span>
                        <p class="text-gray-700">${suggestion}</p>
                    </div>`;
                }
                return '';
            }).join('');
            document.getElementById('suggestions').innerHTML = suggestionsHtml || '<p class="text-gray-500">No suggestions available</p>';
        }

        function animateCircle(id, percent) {
            const circle = document.getElementById(id);
            const circumference = 351.86;
            const offset = circumference - (percent / 100) * circumference;
            
            setTimeout(() => {
                circle.style.transition = 'stroke-dashoffset 1s ease-in-out';
                circle.style.strokeDashoffset = offset;
            }, 100);
        }

        // Load analysis on page load
        loadAnalysis();
    </script>
</body>
</html>
<?php /**PATH D:\TIH\resources\views/feedback.blade.php ENDPATH**/ ?>