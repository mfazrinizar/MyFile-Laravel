<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Get a user's activity logs.
     */
    public function index()
    {
        $logs = ActivityLog::where('user_id', auth()->id())->get();
        return response()->json($logs);
    }

    /**
     * Store a new activity log (typically done automatically in background).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|string',
            'metadata' => 'nullable|json',
            'ip_address' => 'nullable|ip',
            'user_agent' => 'nullable|string',
        ]);

        $log = ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $validated['action'],
            'metadata' => $validated['metadata'] ?? null,
            'ip_address' => $validated['ip_address'],
            'user_agent' => $validated['user_agent'],
        ]);

        return response()->json($log, 201);
    }
}

