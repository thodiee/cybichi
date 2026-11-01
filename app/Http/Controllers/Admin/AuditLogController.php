<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityAuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SecurityAuditLog::with('user');

        if ($request->filled('event')) {
            $query->where('event_type', $request->input('event'));
        }

        $logs = $query->latest('created_at')->paginate(20)->withQueryString();
        return view('admin.audit.index', compact('logs'));
    }
}
