<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerOutreachController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\CustomerOutreach::with(['user.individualVerification', 'user.corporateVerification']);

        // Search by Name, Email, or Phone
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by Verification Status
        if ($request->has('verification_status') && !empty($request->verification_status)) {
            $status = $request->verification_status;
            $dbStatus = strtolower(str_replace(' ', '_', $status)); // e.g. "Not Verified" -> "not_verified"

            $query->where(function($q) use ($status, $dbStatus) {
                if ($dbStatus === 'not_verified') {
                    // "Not Verified" includes:
                    // 1. Users with NO verification record
                    $q->whereDoesntHave('user.individualVerification')
                    // 2. Users with explicit 'not_verified' status
                      ->orWhereHas('user.individualVerification', function($vq) use ($dbStatus) {
                          $vq->where('status', $dbStatus);
                      })
                    // 3. Legacy column matches
                      ->orWhere('verification_status', $status);
                } else {
                    // For Verified, Declined, Resubmit - record must exist
                    $q->whereHas('user.individualVerification', function($vq) use ($dbStatus) {
                        $vq->where('status', $dbStatus);
                    })
                    ->orWhere('verification_status', $status);
                }
            });
        }

        // Sorting
        if ($request->has('sort')) {
            if ($request->sort == 'newest') {
                $query->orderBy('created_at', 'desc');
            } elseif ($request->sort == 'oldest') {
                $query->orderBy('created_at', 'asc');
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default sort
        }

        $outreaches = $query->paginate(20)->withQueryString();
        return view('crm.index', compact('outreaches'));
    }

    public function update(Request $request, $id)
    {
        $outreach = \App\Models\CustomerOutreach::findOrFail($id);
        
        $request->validate([
            'call_status' => 'required|string',
            'customer_feedback_summary' => 'nullable|string',
            'contract_date' => 'nullable|date',
        ]);

        $outreach->update([
            'call_status' => $request->call_status,
            'customer_feedback_summary' => $request->customer_feedback_summary,
            'contract_date' => $request->contract_date,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'CRM Status Updated Successfully']);
        }

        return redirect()->back()->with('success', 'CRM Status Updated Successfully');
    }
}
