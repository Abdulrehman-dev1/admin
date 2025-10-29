<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ReferralController extends Controller
{
    // Show all users with referral info
 public function index()
{
    $users = User::with(['referrer'])
                 ->withCount('referrals')   
                 ->latest()
                 ->paginate(10);

    return view('referral.index', compact('users'));
}
    // Show specific user + who referred him + whom he referred
    public function show($id)
{
    $user = User::with(['referrer','referrals'])->findOrFail($id);

    return view('referral.show', [
        'user' => $user,
        'referrer' => $user->referrer,
        'referrals' => $user->referrals,
    ]);
}

}
