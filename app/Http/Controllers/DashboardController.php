<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\InterviewSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user statistics
        $stats = [
            'total_resumes' => Resume::where('user_id', $user->id)->count(),
            'analyzed_resumes' => Resume::where('user_id', $user->id)
                ->where('status', 'analyzed')
                ->count(),
            'avg_ats_score' => Resume::where('user_id', $user->id)
                ->whereHas('analysis')
                ->join('resume_analyses', 'resumes.id', '=', 'resume_analyses.resume_id')
                ->avg('resume_analyses.ats_score') ?? 0,
            'total_interviews' => InterviewSession::whereHas('resume', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
        ];
        
        // Get recent resumes
        $recentResumes = Resume::where('user_id', $user->id)
            ->with('analysis')
            ->latest('uploaded_at')
            ->limit(5)
            ->get();
        
        return view('dashboard', compact('stats', 'recentResumes'));
    }
}
