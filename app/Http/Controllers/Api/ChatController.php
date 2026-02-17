<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent; // We will create this event later
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UnreadMessageNotification;

class ChatController extends Controller
{
    // List all conversations for the authenticated user
    public function index(Request $request)
    {
        \Log::info('Entering ChatController@index');
        try {
            $userId = Auth::id();

            $conversations = Conversation::with(['userOne', 'userTwo'])
                ->where(function ($query) use ($userId) {
                    $query->where('user_one_id', $userId)
                        ->where('user_one_deleted', false);
                })
                ->orWhere(function ($query) use ($userId) {
                    $query->where('user_two_id', $userId)
                        ->where('user_two_deleted', false);
                })
                ->orderByDesc('updated_at')
                ->get()
                ->map(function ($conversation) use ($userId) {
                    // Determine the other user
                    $otherUser = $conversation->user_one_id == $userId ? $conversation->userTwo : $conversation->userOne;
                    $conversation->other_user = $otherUser;

                    // Determine is_important
                    $conversation->is_important = ($conversation->user_one_id == $userId)
                        ? $conversation->user_one_important
                        : $conversation->user_two_important;

                    // Add last message if needed (can be optimized with relationship)
                    $conversation->last_message = $conversation->messages()->latest()->first();
                    return $conversation;
                });

            return response()->json($conversations);
        } catch (\Throwable $e) {
            \Log::error('ChatController@index crash: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

    // Get messages for a specific conversation
    public function show($id)
    {
        $userId = Auth::id();
        $conversation = Conversation::with(['messages.sender', 'product', 'userOne', 'userTwo'])->findOrFail($id);

        // Authorization check
        if ($conversation->user_one_id != $userId && $conversation->user_two_id != $userId) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Determine the other user
        $otherUser = $conversation->user_one_id == $userId ? $conversation->userTwo : $conversation->userOne;
        $conversation->other_user = $otherUser;

        // Determine is_important
        $conversation->is_important = ($conversation->user_one_id == $userId)
            ? $conversation->user_one_important
            : $conversation->user_two_important;

        return response()->json($conversation);
    }

    // Initiate or get existing conversation
    public function initiate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // The other user (seller)
            'product_id' => 'nullable|exists:auctions,id',
        ]);

        $authUserId = Auth::id();
        $otherUserId = $request->user_id;

        if ($authUserId == $otherUserId) {
            return response()->json(['message' => 'Cannot chat with yourself'], 400);
        }

        // Ensure user_one_id < user_two_id for consistency check, 
        // OR just check both combinations if we don't enforce order.
        // Let's check if conversation exists.

        $conversation = Conversation::where(function ($query) use ($authUserId, $otherUserId) {
            $query->where('user_one_id', $authUserId)->where('user_two_id', $otherUserId);
        })->orWhere(function ($query) use ($authUserId, $otherUserId) {
            $query->where('user_one_id', $otherUserId)->where('user_two_id', $authUserId);
        })->where('product_id', $request->product_id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $authUserId,
                'user_two_id' => $otherUserId,
                'product_id' => $request->product_id,
            ]);
        }

        return response()->json($conversation);
    }

    // Send a message
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'body' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // 10MB limit
        ]);

        if (!$request->body && !$request->hasFile('attachment')) {
            return response()->json(['message' => 'Message cannot be empty'], 400);
        }

        $conversation = Conversation::findOrFail($request->conversation_id);

        if ($conversation->user_one_id != Auth::id() && $conversation->user_two_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $type = 'text';
        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $type = 'image';
            $file = $request->file('attachment');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('assets/images/chat'), $filename);
            $attachmentPath = 'assets/images/chat/' . $filename;
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'body' => $request->body,
            'type' => $type,
            'attachment_path' => $attachmentPath,
        ]);

        // Touch conversation updated_at
        $conversation->touch();

        // Broadcast event
        try {
            broadcast(new MessageSent($message))->toOthers();
        } catch (\Exception $e) {
            \Log::error("Broadcast failed: " . $e->getMessage());
            // Continue without failing the request
        }

        // Send Email Notification if recipient is offline (inactive for > 1 minute)
        try {
            $otherUserId = ($conversation->user_one_id == Auth::id()) ? $conversation->user_two_id : $conversation->user_one_id;
            $recipient = User::find($otherUserId);

            if ($recipient && (!$recipient->last_active_at || $recipient->last_active_at->diffInMinutes(now()) > 1)) {
                Mail::to($recipient->email)->send(new UnreadMessageNotification($recipient, Auth::user(), $message));
            }
        } catch (\Exception $e) {
            \Log::error("Email notification failed: " . $e->getMessage());
        }

        return response()->json($message);
    }

    // Delete conversation (hide from user)
    public function deleteConversation($id)
    {
        $conversation = Conversation::findOrFail($id);
        $userId = Auth::id();

        if ($conversation->user_one_id == $userId) {
            $conversation->user_one_deleted = true;
        } elseif ($conversation->user_two_id == $userId) {
            $conversation->user_two_deleted = true;
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->save();

        return response()->json(['message' => 'Conversation deleted']);
    }

    // Toggle important status
    public function toggleImportant($id)
    {
        $conversation = Conversation::findOrFail($id);
        $userId = Auth::id();

        if ($conversation->user_one_id == $userId) {
            $conversation->user_one_important = !$conversation->user_one_important;
        } elseif ($conversation->user_two_id == $userId) {
            $conversation->user_two_important = !$conversation->user_two_important;
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $conversation->save();

        return response()->json(['message' => 'Conversation importance toggled', 'conversation' => $conversation]);
    }
}
