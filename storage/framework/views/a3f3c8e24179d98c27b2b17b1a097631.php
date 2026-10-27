<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Interview - Nilaa AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <div class="min-h-screen py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">AI Interview Practice</h1>
                <p class="mt-2 text-gray-600">Answer questions and get instant feedback</p>
            </div>

            <!-- Interview Setup -->
            <div id="setupSection" class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Interview Setup</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role Applied</label>
                        <input type="text" id="roleInput" value="Backend Developer (Laravel)" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500" />
                    </div>
                    <button id="startBtn" class="w-full bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white py-3 px-4 rounded-md hover:opacity-90 transition font-semibold shadow-lg">
                        Start Interview
                    </button>
                </div>
            </div>

            <!-- Question Section -->
            <div id="questionSection" class="bg-white rounded-lg shadow-md p-6 hidden">
                <div class="mb-4">
                    <span id="questionNumber" class="text-sm text-gray-500"></span>
                    <h2 id="questionText" class="text-2xl font-bold text-gray-900 mt-2"></h2>
                    <div id="questionMeta" class="mt-2 text-sm text-gray-600"></div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Answer</label>
                        <textarea id="answerInput" rows="6" 
                                  class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                                  placeholder="Type your answer here..."></textarea>
                    </div>
                    
                    <div class="flex gap-4">
                        <button id="submitAnswerBtn" class="flex-1 bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white py-3 px-4 rounded-md hover:opacity-90 transition font-semibold shadow-lg">
                            Submit Answer
                        </button>
                        <button id="skipBtn" class="px-6 py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                            Skip
                        </button>
                    </div>
                </div>

                <!-- Evaluation Display -->
                <div id="evaluation" class="mt-6 p-4 bg-purple-50 border border-purple-200 rounded-md hidden">
                    <h3 class="font-bold text-purple-900 mb-2">Evaluation</h3>
                    <div id="evaluationContent"></div>
                    <button id="nextBtn" class="mt-4 w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-4 rounded-md hover:opacity-90 transition font-semibold">
                        Next Question
                    </button>
                </div>
            </div>

            <!-- Completion -->
            <div id="completionSection" class="bg-white rounded-lg shadow-md p-6 text-center hidden">
                <svg class="mx-auto h-16 w-16 text-green-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">Interview Complete!</h2>
                <p class="text-gray-600 mb-6">View your complete feedback and analysis</p>
                <a href="/feedback/<?php echo e($resumeId); ?>" class="inline-block bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white py-3 px-6 rounded-md hover:opacity-90 transition font-semibold shadow-lg">
                    View Feedback
                </a>
            </div>
        </div>
    </div>

    <script>
        const resumeId = <?php echo e($resumeId); ?>;
        let sessionId = null;
        let questions = [];
        let currentQuestionIndex = 0;

        document.getElementById('startBtn').addEventListener('click', async () => {
            const role = document.getElementById('roleInput').value;
            
            const response = await fetch(`/api/interview/${resumeId}/start`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ role_applied: role, mode: 'text' })
            });
            
            const data = await response.json();
            sessionId = data.interview_session_id;
            questions = data.questions;
            
            document.getElementById('setupSection').classList.add('hidden');
            document.getElementById('questionSection').classList.remove('hidden');
            
            showQuestion(0);
        });

        function showQuestion(index) {
            if (index >= questions.length) {
                document.getElementById('questionSection').classList.add('hidden');
                document.getElementById('completionSection').classList.remove('hidden');
                return;
            }
            
            currentQuestionIndex = index;
            const q = questions[index];
            
            document.getElementById('questionNumber').textContent = `Question ${index + 1} of ${questions.length}`;
            document.getElementById('questionText').textContent = q.question_text;
            document.getElementById('questionMeta').textContent = `Type: ${q.type} | Difficulty: ${q.difficulty}/5`;
            document.getElementById('answerInput').value = '';
            document.getElementById('evaluation').classList.add('hidden');
        }

        document.getElementById('submitAnswerBtn').addEventListener('click', async () => {
            const answer = document.getElementById('answerInput').value.trim();
            if (!answer) {
                alert('Please provide an answer');
                return;
            }
            
            const questionId = questions[currentQuestionIndex].id;
            
            const response = await fetch(`/api/interview/${sessionId}/answer`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question_id: questionId, answer_text: answer })
            });
            
            const data = await response.json();
            displayEvaluation(data.evaluation);
        });

        function displayEvaluation(evaluation) {
            const content = `
                <p class="mb-2"><strong>Score:</strong> ${evaluation.score}/100</p>
                <p class="mb-2"><strong>Strengths:</strong> ${evaluation.strengths.join(', ') || 'N/A'}</p>
                <p><strong>Areas to improve:</strong> ${evaluation.weaknesses.join(', ') || 'N/A'}</p>
            `;
            
            document.getElementById('evaluationContent').innerHTML = content;
            document.getElementById('evaluation').classList.remove('hidden');
        }

        document.getElementById('nextBtn').addEventListener('click', () => {
            showQuestion(currentQuestionIndex + 1);
        });

        document.getElementById('skipBtn').addEventListener('click', () => {
            showQuestion(currentQuestionIndex + 1);
        });
    </script>
</body>
</html>
<?php /**PATH D:\TIH\resources\views/interview.blade.php ENDPATH**/ ?>