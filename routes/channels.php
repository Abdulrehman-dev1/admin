<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);
    return $conversation && ($user->id === $conversation->user_one_id || $user->id === $conversation->user_two_id);
});

Broadcast::channel('online', function ($user) {
    if (auth()->check()) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'profile_pic' => $user->profile_pic,
            'last_active_at' => $user->last_active_at
        ];
    }
});
