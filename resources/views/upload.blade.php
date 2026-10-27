@extends('layouts.dashboard')

@section('title', 'Upload Resume')
@section('page-title', 'Upload Resume')

@section('content')
    <div class="p-6 lg:p-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Upload Your Resume</h2>
                <p class="text-gray-600">Get AI-powered analysis and personalized interview questions</p>
            </div>

            <!-- Upload Form -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form id="uploadForm" enctype="multipart/form-data">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                        <input type="file" id="fileInput" name="file" accept=".pdf,.doc,.docx" class="hidden" />
                        <label for="fileInput" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-semibold text-purple-600">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500">PDF, DOC, or DOCX (max 5MB)</p>
                        </label>
                        <div id="fileName" class="mt-4 text-sm text-gray-700 hidden"></div>
                    </div>
                    
                    <button type="submit" id="uploadBtn" class="mt-6 w-full bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white py-3 px-4 rounded-md hover:opacity-90 transition disabled:bg-gray-400 font-semibold shadow-lg">
                        Upload & Analyze
                    </button>
                </form>
                
                <!-- Progress -->
                <div id="progress" class="mt-4 hidden">
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div id="progressBar" class="bg-gradient-to-r from-purple-600 to-pink-600 h-2.5 rounded-full transition-all" style="width: 0%"></div>
                    </div>
                    <p id="progressText" class="text-sm text-gray-600 mt-2 text-center"></p>
                </div>
            </div>

            <!-- Recent Uploads -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Recent Uploads</h2>
                <div id="recentResumes" class="space-y-4">
                    <p class="text-gray-500 text-center py-4">No resumes uploaded yet</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const fileInput = document.getElementById('fileInput');
        const fileName = document.getElementById('fileName');
        const uploadForm = document.getElementById('uploadForm');
        const uploadBtn = document.getElementById('uploadBtn');
        const progress = document.getElementById('progress');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                fileName.textContent = `Selected: ${e.target.files[0].name}`;
                fileName.classList.remove('hidden');
            }
        });

        uploadForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!fileInput.files.length) {
                alert('Please select a file to upload');
                return;
            }
            
            const formData = new FormData();
            formData.append('file', fileInput.files[0]);
            
            uploadBtn.disabled = true;
            progress.classList.remove('hidden');
            progressText.textContent = 'Uploading...';
            progressBar.style.width = '50%';
            
            try {
                const response = await fetch('/api/upload-resume', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: formData,
                    credentials: 'same-origin'
                });
                
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    throw new Error('Server returned non-JSON response. Please check if you are logged in.');
                }
                
                const data = await response.json();
                
                if (response.ok) {
                    progressBar.style.width = '100%';
                    progressText.textContent = 'Upload successful! Analyzing...';
                    
                    setTimeout(() => {
                        window.location.href = `/feedback/${data.resume_id}`;
                    }, 1500);
                } else {
                    alert('Upload failed: ' + (data.message || 'Unknown error'));
                    uploadBtn.disabled = false;
                    progress.classList.add('hidden');
                    progressBar.style.width = '0%';
                }
            } catch (error) {
                console.error('Upload error:', error);
                alert('Upload failed: ' + error.message);
                uploadBtn.disabled = false;
                progress.classList.add('hidden');
                progressBar.style.width = '0%';
            }
        });
    </script>
@endpush
