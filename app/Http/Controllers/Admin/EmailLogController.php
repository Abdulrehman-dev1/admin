<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use Illuminate\Http\Request;

class EmailLogController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailLog::with('user')->orderBy('sent_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('recipient_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('date_range')) {
             // Assuming date_range format is "YYYY-MM-DD to YYYY-MM-DD" or similar
             // We can use a simple date filter for now
             $dates = explode(' to ', $request->date_range);
             if (count($dates) === 2) {
                 $query->whereBetween('sent_at', [$dates[0] . ' 00:00:00', $dates[1] . ' 23:59:59']);
             }
        }

        $emailLogs = $query->paginate(20)->withQueryString();

        return view('admin.email_logs.index', compact('emailLogs'));
    }
}
