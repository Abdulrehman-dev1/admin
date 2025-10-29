<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\CorporateVerification;
use App\Models\NewNotification;
use App\Mail\CorporateVerificationAcceptedMail;
use App\Mail\CorporateVerificationDeclinedMail;
use App\Mail\CorporateVerificationStatusUpdated;

class CorporateVerificationController extends Controller
{
    public function index()
    {
        $verifications = CorporateVerification::with('user')->latest()->get();
        return view('corporate_verifications.index', compact('verifications'));
    }

    public function edit($id)
    {
        $verification = CorporateVerification::findOrFail($id);
        return view('corporate_verifications.edit', compact('verification'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $data = $request->validate([
            'legal_entity_name'      => 'required|string',
            'registered_address'     => 'required|string',
            'date_of_incorporation'  => 'required|date',
            'entity_type'            => 'required|string',
            'business_documents'     => 'required|array|min:1|max:3',
            'business_documents.*'   => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'country'                => 'required|string',
        ]);

        // Ensure public folder exists
        $destination = public_path('assets/images/corporate_verifications');
        if (! file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move each uploaded file into that folder
        $relativePaths = [];
        foreach ($request->file('business_documents') as $file) {
            $filename = Str::random(12) . '.' . $file->getClientOriginalExtension();
            $file->move($destination, $filename);
            $relativePaths[] = 'assets/images/corporate_verifications/' . $filename;
        }

        $cv = CorporateVerification::create([
            'user_id'               => $user->id,
            'legal_entity_name'     => $data['legal_entity_name'],
            'registered_address'    => $data['registered_address'],
            'date_of_incorporation' => $data['date_of_incorporation'],
            'entity_type'           => $data['entity_type'],
            'business_documents'    => $relativePaths,
            'country'               => $data['country'],
            'status'                => 'not_verified',
        ]);

        return response()->json($cv, 201);
    }

    public function show($id)
    {
        return CorporateVerification::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cv = CorporateVerification::findOrFail($id);

        $data = $request->validate([
            'legal_entity_name'      => 'required|string',
            'registered_address'     => 'required|string',
            'date_of_incorporation'  => 'required|date',
            'entity_type'            => 'required|string',
            'business_documents'     => 'sometimes|array|min:1|max:3',
            'business_documents.*'   => 'file|mimes:jpg,jpeg,png,pdf|max:2048',
            'country'                => 'required|string',
        ]);

        $oldStatus = (string) ($cv->status ?? '');

        // Handle new uploads
        if ($request->hasFile('business_documents')) {
            $destination = public_path('assets/images/corporate_verifications');
            if (! file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $relativePaths = [];
            foreach ($request->file('business_documents') as $file) {
                $filename = Str::random(12) . '.' . $file->getClientOriginalExtension();
                $file->move($destination, $filename);
                $relativePaths[] = 'assets/images/corporate_verifications/' . $filename;
            }
            $cv->business_documents = $relativePaths;
        }

        // Update attributes
        $cv->update([
            'legal_entity_name'     => $data['legal_entity_name'],
            'registered_address'    => $data['registered_address'],
            'date_of_incorporation' => $data['date_of_incorporation'],
            'entity_type'           => $data['entity_type'],
            'country'               => $data['country'],
        ]);

        // Mark for resubmit & clear decline reason
        $cv->status         = 'resubmit';
        $cv->decline_reason = null;
        $cv->save();

        // Email if status actually changed
        $emailed   = false;
        $mailError = null;
        $newStatus = (string) $cv->status;

        if ($oldStatus !== $newStatus) {
            try {
                $recipient = optional($cv->user)->email;
                if ($recipient) {
                    Mail::to($recipient)
                        ->bcc(config('app.admin_email'))
                        ->send(new CorporateVerificationStatusUpdated($cv, $oldStatus, $newStatus));
                        // ->queue(new CorporateVerificationStatusUpdated($cv, $oldStatus, $newStatus));
                    $emailed = true;
                }
            } catch (\Throwable $e) {
                $mailError = config('app.debug') ? $e->getMessage() : 'mail_failed';
            }
        }

        return response()->json([
            'verification' => $cv,
            'email' => [
                'attempted' => ($oldStatus !== $newStatus),
                'sent'      => $emailed,
                'error'     => $mailError,
            ],
        ]);
    }

    public function destroy($id)
    {
        $verification = CorporateVerification::findOrFail($id);
        $verification->delete();

        return redirect()
            ->route('corporate-verifications.index')
            ->with('success', 'Corporate verification deleted successfully.');
    }

    public function accept($id)
    {
        $cv = CorporateVerification::findOrFail($id);
        $oldStatus = (string) ($cv->status ?? '');
        $cv->status = 'verified';
        $cv->save();

        // 1) send approval email (safe-fail + admin BCC)
        $emailed = false; $mailError = null;
        try {
            $recipient = optional($cv->user)->email;
            if ($recipient) {
                Mail::to($recipient)
                    ->bcc(config('app.admin_email'))
                    ->send(new CorporateVerificationAcceptedMail($cv));
                    // ->queue(new CorporateVerificationAcceptedMail($cv));
                $emailed = true;
            }
        } catch (\Throwable $e) {
            $mailError = config('app.debug') ? $e->getMessage() : 'mail_failed';
        }

        // 2) in-app notification
        NewNotification::create([
            'user_id'   => $cv->user_id,
            'title'     => 'Corporate Verification Accepted',
            'message'   => 'Congratulations! Your corporate verification has been approved.',
            'type'      => 'wallet',
            'image_url' => NewNotification::getImageForType('wallet'),
            'read_at'   => null,
        ]);

        return redirect()
            ->route('corporate-verifications.index')
            ->with('success', 'Corporate verification accepted and user notified!');
    }

    public function decline(Request $request, $id)
    {
        $request->validate(['decline_reason' => 'required|string']);

        $cv = CorporateVerification::findOrFail($id);
        $oldStatus = (string) ($cv->status ?? '');
        $cv->status         = 'declined';
        $cv->decline_reason = $request->decline_reason;
        $cv->save();

        $resubmitUrl = 'http://xpertbid.com/corporate-verify/' . $cv->id;

        // 1) decline email (safe-fail + admin BCC)
        $emailed = false; $mailError = null;
        try {
            $recipient = optional($cv->user)->email;
            if ($recipient) {
                Mail::to($recipient)
                    ->bcc(config('app.admin_email'))
                    ->send(new CorporateVerificationDeclinedMail($cv, $request->decline_reason, $resubmitUrl));
                    // ->queue(new CorporateVerificationDeclinedMail(...));
                $emailed = true;
            }
        } catch (\Throwable $e) {
            $mailError = config('app.debug') ? $e->getMessage() : 'mail_failed';
        }

        // 2) in-app notification
        NewNotification::create([
            'user_id'   => $cv->user_id,
            'title'     => 'Corporate Verification Declined',
            'message'   => "Your corporate verification was declined: {$request->decline_reason}",
            'type'      => 'bid',
            'image_url' => NewNotification::getImageForType('bid'),
            'read_at'   => null,
        ]);

        return redirect()
            ->route('corporate-verifications.index')
            ->with('success', 'Corporate verification declined & user notified!');
    }
}
