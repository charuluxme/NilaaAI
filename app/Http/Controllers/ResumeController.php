<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    /**
     * Display upload form
     */
    public function uploadForm()
    {
        return view('upload');
    }
    
    /**
     * Display all resumes
     */
    public function index()
    {
        $resumes = Resume::where('user_id', Auth::id())
            ->with(['analysis', 'skillTags'])
            ->latest('uploaded_at')
            ->paginate(10);
        
        return view('resumes.index', compact('resumes'));
    }
    
    /**
     * Show a single resume
     */
    public function show(Resume $resume)
    {
        // Ensure user owns this resume
        if ($resume->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        $resume->load(['analysis', 'skillTags', 'interviewSessions']);
        
        return view('resumes.show', compact('resume'));
    }
}
