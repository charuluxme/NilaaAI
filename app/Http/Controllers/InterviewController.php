<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\InterviewSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    /**
     * Display all interviews
     */
    public function index()
    {
        $sessions = InterviewSession::whereHas('resume', function ($query) {
            $query->where('user_id', Auth::id());
        })
        ->with(['resume', 'questions'])
        ->latest('started_at')
        ->paginate(10);
        
        return view('interviews.index', compact('sessions'));
    }
    
    /**
     * Show interview for a resume
     */
    public function show(Resume $resume)
    {
        // Ensure user owns this resume
        if ($resume->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('interview', ['resumeId' => $resume->id]);
    }
}
