<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use App\Models\Notification;

class ProfileController extends Controller
{
     // Fetch user profile
    public function getProfileMobile()
     {   
         
         $user =  Auth::user();
    logger($user);
    $user->load('country');
        
       
        
        return response()->json(['profile' => $user], 200);
    }
    
    // Fetch user profile
    public function getProfile()
    {
        
        
        return response()->json(['profile' => Auth::user()], 200);
    }

    // Update user profile
public function updateProfile(Request $request)
{
    $user = Auth::user();

    // Input fields validate karain
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'vat_number' => 'nullable|string|max:255',
        'company_name' => 'nullable|string|max:255',
    ]);
    
    if ($request->filled('country_id') && $request->country_id !== "null" && $request->country_id !== null) {
    	$country = Country::find($request->country_id);
    } elseif ($request->filled('country_code') && $request->country_code !== "null" && $request->country_code !== null) {
        $country = Country::where('sortname', $request->country_code)->first();
    } else {
        $country = null;
    }
    
    if($country){}
    
  // 2) Build the data array with always-updated fields
    $data = [
        'name'       => $request->name,
        'phone'      => $request->phone,
        
        'usertype'   => $request->usertype,
        'username'   => $request->username,
        'vat_number'    => $request->vat_number,     
        'company_name'  => $request->company_name,  
        ];
        
        // Add country_id if country exists
if ($country) {
    $data['country_id'] = $country->id;
}
    // Profile picture update handling (agar file upload hai)
    if ($request->hasFile('profile_pic')) {
        $image = $request->file('profile_pic');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('/assets/images/profile/'), $imageName);
        $user->profile_pic = '/assets/images/profile/' . $imageName;
    }   // 2) Explicit “remove” (we send an empty string)
    else {
     $data['profile_pic'] = '/assets/images/user.jpg';
	}
  	
    // 4) Massupdate
    $user->update($data);

    // User details update
  

    // Account Change Notification ka email bhejne ka logic
    // Yahan hum assume kar rahe hain ke yeh updateProfile method ka "changeType" hoga "Profile Updated"
    $changeType = 'Profile Updated'; 
    $timestamp = now()->toDayDateTimeString();

    try {
        \Mail::to($user->email)->send(new \App\Mail\AccountChangeNotification($user->name, $changeType, $timestamp));
    } catch (\Exception $e) {
        \Log::error('Account change notification email failed: ' . $e->getMessage());
    }
    $user->load('country');
    return response()->json([
        'message' => 'Profile updated successfully.',
        'profile' => $user,
    ]);
}


    // Fetch user address
    public function getAddress()
    {	//dd(Auth::user());
      	$address = Address::where("user_id",Auth::user()->id)->first();
        return response()->json($address ?? [], 200);
    }

    // Update user address
 public function updateAddress(Request $request)
{
    $request->validate([
        'addressLine1' => 'required',
        'city'         => 'required',
        'state'        => 'required',
    ], [
        'addressLine1.required' => 'Please enter your street address.',
        'city.required'         => 'Please enter your city.',
        'state.required'        => 'Please enter your state or province.',
    ]);

    $user = Auth::user();

    // Add 'user_id' here as well!
    $data = [
        'user_id'       => $user->id, // <- Zaroori hai!
        'addressLine1'  => $request->addressLine1,
        'addressLine2'  => $request->addressLine2 ?? null,
        'city'          => $request->city,
        'state'         => $request->state,
        'postalCode'    => $request->postalCode,
        'country'       => $request->country ?? null,
        'contactNumber' => $request->contactNumber ?? null,
        'otherNumber'   => $request->otherNumber ?? null,
    ];

    $address = Address::updateOrCreate(
        ['user_id' => $user->id],
        $data
    );

    return response()->json(['message' => 'Address updated successfully.', 'address' => $address]);
}
    // Update user address
 public function updateAddressMobile(Request $request)
{
    $request->validate([
        'addressLine1' => 'required',
        'city'         => 'required',
        'state'        => 'required',
        'country_code' => 'required',
    ], [
        'addressLine1.required' => 'Please enter your street address.',
        'city.required'         => 'Please enter your city.',
        'state.required'        => 'Please enter your state or province.',
        'country_code.required' => 'Please enter your country',
    ]);
    $country = Country::where("sortname", $request->country_code)->first();
    $user = Auth::user();

    // Add 'user_id' here as well!
    $data = [
        'user_id'       => $user->id, // <- Zaroori hai!
        'addressLine1'  => $request->addressLine1,
        'addressLine2'  => $request->addressLine2 ?? null,
        'city'          => $request->city,
        'state'         => $request->state,
        'postalCode'    => $request->postalCode,
        'country'       => $country->id ?? null,
        'contactNumber' => $request->contactNumber ?? null,
        'otherNumber'   => $request->otherNumber ?? null,
    ];

    $address = Address::updateOrCreate(
        ['user_id' => $user->id],
        $data
    );

    return response()->json(['message' => 'Address updated successfully.', 'address' => $address]);
}

  // Fetch notification settings
    public function getNotificationSettings()
    {	
      	$notification = Notification::where("user_id",Auth::user()->id)->first();
        return response()->json($notification ?? [], 200);
    }

    // Update notification settings
    public function updateNotificationSettings(Request $request)
    {
        $user = Auth::user();
      	$notification = Notification::updateOrCreate(
            ['user_id' => $user->id],
            $request->biddingConditions
        );

        return response()->json(['message' => 'Notification settings updated successfully.','notification' => $notification]);
    }

    // Update password
  public function updatePassword(Request $request)
{
    $request->validate([
        'oldPassword' => 'required',
        'newPassword' => 'required|min:8|confirmed', // `confirmed` requires `newPassword_confirmation`
    ]);

    $user = Auth::user();
    // print_r($user);
    if (!Hash::check($request->oldPassword, $user->password)) {
        return response()->json(['message' => 'Old password is incorrect.'], 422);
    }

    $user->password = Hash::make($request->newPassword);
    $user->save();

    return response()->json(['message' => 'Password updated successfully.']);
}

public function saveIdentityVerification(Request $request)
{
    $user = Auth::user();
    $idDocs = [];

    if ($request->hasFile('id_documents')) {
        foreach ($request->file('id_documents') as $file) {
            $filename = time()
                      . '_id_'
                      . Str::random(8)
                      . '.'
                      . $file->getClientOriginalExtension();

            // 1) move into public/assets/images/identity_verifications/
            $file->move(
                public_path('assets/images/identity_verifications'),
                $filename
            );

            // 2) store the *same* public path (no leading slash)
            $idDocs[] = "assets/images/identity_verifications/{$filename}";
        }
    }

    $identity = $user->identity_verification()->updateOrCreate(
        ['user_id' => $user->id],
        array_merge(
            $request->only([
                'user_type',
                'full_legal_name',
                'dob',
                'nationality',
                'residential_address',
                'contact_number',
                'email_address',
                // etc…
            ]),
            [
                'id_documents' => $idDocs,
                'status'       => $request->get('status', 'not_verified'),
            ]
        )
    );

    return response()->json([
        'message'      => 'Identity verification saved successfully.',
        'id_documents' => $idDocs,
    ]);
}
    // Fetch identity verification details
    public function getIdentityVerification()
    {
        return response()->json(Auth::user()->identity_verification ?? []);
    }
   public function validateReferral(Request $request)
{
    $request->validate([
        'referral_code' => 'required|string'
    ]);

    $user = $request->user();

    if (!$user) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized. Please login again.'
        ], 401);
    }

    $referrer = User::where('referral_code', $request->referral_code)->first();

    if (!$referrer) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid referral code.'
        ], 404);
    }

    if ($referrer->id === $user->id) {
        return response()->json([
            'success' => false,
            'message' => 'You cannot use your own referral code.'
        ], 400);
    }

    if ($user->referred_by) {
        return response()->json([
            'success' => false,
            'message' => 'Referral already applied.'
        ], 400);
    }

    $user->referred_by = $referrer->id;
    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Referral applied successfully.',
        'referrer' => $referrer->only('id', 'name', 'email')
    ]);
}


}
