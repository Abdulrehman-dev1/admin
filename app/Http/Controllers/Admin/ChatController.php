<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;

class ChatController extends Controller
{
    // List all conversations
    public function index()
    {
        $conversations = Conversation::with(['userOne', 'userTwo', 'product'])
            ->withCount('messages')
            ->orderByDesc('updated_at')
            ->paginate(20);

        return view('admin.chat.index', compact('conversations'));
    }

    // Show conversation transcript
    public function show($id)
    {
        $conversation = Conversation::with(['messages.sender', 'userOne', 'userTwo', 'product'])->findOrFail($id);
        
        return view('admin.chat.show', compact('conversation'));
    }
}
