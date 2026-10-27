<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resume;
use App\Models\InterviewSession;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_resumes' => Resume::count(),
            'total_interviews' => InterviewSession::count(),
            'resumes_today' => Resume::whereDate('uploaded_at', today())->count(),
            'avg_ats_score' => Resume::whereHas('analysis')
                ->join('resume_analyses', 'resumes.id', '=', 'resume_analyses.resume_id')
                ->avg('resume_analyses.ats_score') ?? 0,
        ];
        
        // Recent activity
        $recentUsers = User::latest()->limit(5)->get();
        $recentResumes = Resume::with('user')->latest('uploaded_at')->limit(10)->get();
        
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentResumes'));
    }
    
    /**
     * Display analytics
     */
    public function analytics()
    {
        // Get various analytics data
        $userGrowth = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
        
        $resumeStats = Resume::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();
        
        return view('admin.analytics', compact('userGrowth', 'resumeStats'));
    }
}
