<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nilaa AI - AI-Powered Resume Analysis & Interview Practice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg border-b border-gray-200 fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#home" class="flex items-center">
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">
                            Nilaa AI
                        </span>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition">About</a>
                    <a href="#demo" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition">Demo</a>
                    <a href="#contact" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition">Contact</a>
                    
                    @auth
                        <a href="/dashboard" class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition shadow-md">
                            Dashboard
                        </a>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-purple-600 px-3 py-2 text-sm font-medium transition">Login</a>
                        <a href="/register" class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white px-6 py-2 rounded-lg text-sm font-semibold hover:opacity-90 transition shadow-md">
                            Get Started
                        </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="mobileOpen = !mobileOpen" class="text-gray-700 hover:text-purple-600" x-data="{ mobileOpen: false }">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Home Section -->
    <section id="home" class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50 pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center mb-16">
                <h1 class="text-6xl md:text-7xl font-extrabold mb-6">
                    <span class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 bg-clip-text text-transparent">Nilaa AI</span>
                </h1>
                <p class="text-3xl text-gray-700 mb-4">AI-Powered Resume Analysis & Interview Practice</p>
                <p class="text-xl text-gray-600 mb-8">Get instant feedback, improve your resume, and ace your interviews</p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                    @auth
                        <a href="/upload" class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:opacity-90 transition shadow-lg">
                            Upload Resume
                        </a>
                        <a href="/dashboard" class="bg-white text-gray-700 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition border-2 border-gray-200">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="/register" class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:opacity-90 transition shadow-lg">
                            Get Started Free
                        </a>
                        <a href="/login" class="bg-white text-gray-700 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition border-2 border-gray-200">
                            Login
                        </a>
                    @endauth
                </div>

                <p class="text-sm text-gray-500">No credit card required • Free analysis • Instant results</p>
            </div>

            <!-- Feature Cards -->
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Resume Analysis</h3>
                    <p class="text-gray-600">Get ATS score, skill detection, and actionable suggestions to optimize your resume</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-100 to-pink-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">AI Interview</h3>
                    <p class="text-gray-600">Practice with personalized questions and receive instant, actionable feedback</p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition transform hover:-translate-y-1">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Instant Results</h3>
                    <p class="text-gray-600">Real-time processing with detailed improvement plans and career guidance</p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-8 text-center">
                <div>
                    <p class="text-5xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">10K+</p>
                    <p class="text-gray-600 mt-2">Resumes Analyzed</p>
                </div>
                <div>
                    <p class="text-5xl font-bold bg-gradient-to-r from-pink-600 to-blue-600 bg-clip-text text-transparent">95%</p>
                    <p class="text-gray-600 mt-2">Interview Success</p>
                </div>
                <div>
                    <p class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">4.9★</p>
                    <p class="text-gray-600 mt-2">User Rating</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">About Nilaa AI</h2>
                <p class="text-xl text-gray-600">Your intelligent career companion</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-6">Who We Are</h3>
                    <p class="text-gray-600 mb-4 text-lg leading-relaxed">
                        Nilaa AI is an advanced AI-powered platform designed to help job seekers optimize their resumes and excel in interviews. 
                        We leverage cutting-edge artificial intelligence to provide personalized feedback and actionable insights.
                    </p>
                    <p class="text-gray-600 mb-6 text-lg leading-relaxed">
                        Our mission is to democratize access to professional career coaching and make it available to everyone, 
                        regardless of their background or resources.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-gray-700">AI-powered resume analysis with ATS optimization</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-gray-700">Personalized interview questions based on your resume</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-gray-700">Real-time feedback and improvement suggestions</p>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <p class="text-gray-700">Comprehensive skill detection and matching</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-100 via-pink-100 to-blue-100 rounded-2xl p-12 text-center">
                    <div class="bg-white rounded-xl shadow-xl p-8">
                        <div class="text-6xl mb-4">🎯</div>
                        <h4 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h4>
                        <p class="text-gray-600 text-lg">
                            Empowering every job seeker with AI-driven insights to land their dream career
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-20 bg-gradient-to-br from-purple-50 via-pink-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">See Nilaa AI in Action</h2>
                <p class="text-xl text-gray-600">Watch how our platform transforms your job search</p>
            </div>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Demo Step 1 -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">1</div>
                        <h3 class="text-2xl font-bold text-gray-900">Upload Your Resume</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Simply drag and drop your resume in PDF or DOCX format. Our AI will instantly start analyzing it.</p>
                    <div class="bg-gray-100 rounded-lg p-6 border-2 border-dashed border-gray-300 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-gray-500">Drop your resume here</p>
                    </div>
                </div>

                <!-- Demo Step 2 -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-pink-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">2</div>
                        <h3 class="text-2xl font-bold text-gray-900">Get Instant Analysis</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Receive your ATS score, detected skills, and personalized improvement suggestions within seconds.</p>
                    <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-700 font-medium">ATS Score:</span>
                            <span class="text-2xl font-bold text-green-600">85/100</span>
                        </div>
                        <div class="mb-3">
                            <span class="text-gray-700 font-medium">Skills Detected:</span>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">Python</span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">React</span>
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">SQL</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo Step 3 -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">3</div>
                        <h3 class="text-2xl font-bold text-gray-900">Practice Interviews</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Face AI-generated interview questions tailored to your resume and receive real-time feedback.</p>
                    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-sm text-purple-600 font-medium mb-1">Question 1</p>
                            <p class="text-gray-800">Tell me about your experience with Python and web development.</p>
                        </div>
                        <div class="bg-white rounded-lg p-4 shadow-sm">
                            <p class="text-sm text-purple-600 font-medium mb-1">Question 2</p>
                            <p class="text-gray-800">How do you approach debugging complex issues?</p>
                        </div>
                    </div>
                </div>

                <!-- Demo Step 4 -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-4">4</div>
                        <h3 class="text-2xl font-bold text-gray-900">Get Detailed Feedback</h3>
                    </div>
                    <p class="text-gray-600 mb-4">Review comprehensive feedback on your answers with strengths, weaknesses, and improvement tips.</p>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4">
                        <div class="mb-3">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm text-gray-700">Overall Score</span>
                                <span class="text-sm font-bold text-purple-600">8.5/10</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="text-sm">
                            <p class="text-green-700 mb-1">✓ Strong technical knowledge</p>
                            <p class="text-yellow-700">⚠ Add more specific examples</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="/register" class="bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:opacity-90 transition shadow-lg inline-block">
                    Try It Free Now
                </a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Get In Touch</h2>
                <p class="text-xl text-gray-600">Have questions? We'd love to hear from you</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">Email</p>
                                <a href="mailto:support@nilaa.ai" class="text-purple-600 hover:text-purple-700">support@nilaa.ai</a>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">Location</p>
                                <p class="text-gray-600">San Francisco, CA</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900">Support Hours</p>
                                <p class="text-gray-600">24/7 AI Support</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-200">
                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Your name">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="your@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="How can we help you?"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600 text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-purple-400 via-pink-400 to-blue-400 bg-clip-text text-transparent mb-4">Nilaa AI</h3>
                    <p class="text-gray-400">Empowering job seekers with AI-driven career tools</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Product</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#demo" class="hover:text-white transition">Demo</a></li>
                        <li><a href="/register" class="hover:text-white transition">Get Started</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Company</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#contact" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Legal</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">© 2025 Nilaa AI. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
