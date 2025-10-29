<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('IndividualVerification')->get();
		//dd($users);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
   // app/Http/Controllers/UserController.php



   public function create()
{
    // Option A: hard‑coded list
    $roles = [
        'admin',
        'user',
        // …add as needed
    ];

    $user = new User();  // for old('role', $user->role ?? '')
    return view('users.create', compact('roles', 'user'));
}


    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * 
     **/
public function store(Request $request)
{
    $data = $request->validate([
        'name'      => 'required|string|max:255',
        'username'  => 'required|string|max:255|unique:users,username',
        'email'     => 'required|email|max:255|unique:users,email',
        'password'  => 'required|string|min:8|confirmed',
        'phone'     => 'required|string|max:20',
        'role'      => 'required|string|in:admin,user',
        'country_id'=> 'required|exists:countries,id',
        'city_id'   => 'required|exists:cities,id',
        'address'   => 'nullable|string|max:500',
    ]);

    $data['password'] = bcrypt($data['password']);

    $user = User::create($data);

    return redirect()
        ->route('users.index')
        ->with('success','User created successfully.');
}
    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
 public function edit(User $user)
    {
        $roles = ['admin','user'];
        return view('users.create', compact('roles','user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
 public function update(Request $request, User $user)
{
    $data = $request->validate([
        'name'      => 'required|string|max:255',
        'username'  => "required|string|max:255|unique:users,username,{$user->id}",
        'email'     => "required|email|max:255|unique:users,email,{$user->id}",
        'password'  => 'nullable|string|min:8|confirmed',
        'phone'     => 'required|string|max:20',
        'role'      => 'required|string|in:admin,user',
        'country_id'=> 'required|exists:countries,id',
        'city_id'   => 'required|exists:cities,id',
        'address'   => 'nullable|string|max:500',
    ]);

    if (!empty($data['password'])) {
        $data['password'] = bcrypt($data['password']);
    } else {
        unset($data['password']);
    }

    $user->update($data);

    return redirect()
        ->route('users.index')
        ->with('success','User updated successfully.');
}
public function updateStatus(User $user, Request $request)
{
    // If the checkbox is checked, the form submits status="on". 
    // If it’s unchecked, no “status” key is sent.
    $newStatus = $request->has('status')
               ? 'enable'
               : 'disable';

    $user->status = $newStatus;
    $user->save();

    return redirect()
        ->route('users.index')
        ->with('success', "User status updated to {$newStatus}.");
}


    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function account_settings(Request $request)
    {
        return response()->json(['message' => 'Logged out successfully']);
    }
    // In your user model
public function updateOneSignalPlayerId(Request $request)
{
    $user = auth()->user();
    $user->onesignal_player_id = $request->player_id;
    $user->save();
}
public function getUserProfile()
{   $id = Auth::user()->id;
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Check if profile_pic is an external URL (like Google or Facebook)
    if ($user->profile_pic && preg_match('/^https?:\/\//', $user->profile_pic)) {
        // If profile_pic starts with "http" or "https", return it directly (Google, Facebook, etc.)
        $profilePicUrl = $user->profile_pic;
    } else {
        // Otherwise, assume it's a locally uploaded file and construct the correct URL
        $profilePicUrl = asset('' . $user->profile_pic);
    }

    return response()->json([
        'name' => $user->name,
        'profile_pic' => $profilePicUrl, // Now correctly formatted
    ]);
}

    /**
     * Verify if the specified user exists.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(Request $request, $id)
    {
        // Optionally, verify the Authorization header if needed.
        // $token = $request->bearerToken();
        // Perform any token validation here if required.

        // Attempt to find the user by ID.
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Return the user data as JSON.
        return response()->json($user, 200);
    }
}





