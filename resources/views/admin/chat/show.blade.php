@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom bg-white d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        Chat: {{ $conversation->userOne->name }} vs {{ $conversation->userTwo->name }}
                        @if($conversation->product)
                            <small class="text-muted">({{ $conversation->product->title }})</small>
                        @endif
                    </h4>
                    <a href="{{ route('admin.chats.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>
                <div class="card-body p-0" style="max-height: 600px; overflow-y: auto;">
                    <div class="p-4">
                        @foreach($conversation->messages as $message)
                            <div class="d-flex mb-4 {{ $message->sender_id == $conversation->user_one_id ? 'justify-content-start' : 'justify-content-end' }}">
                                <div class="p-3 rounded {{ $message->sender_id == $conversation->user_one_id ? 'bg-light text-dark' : 'bg-primary text-white' }}" style="max-width: 70%;">
                                    <small class="d-block mb-1 opacity-75">
                                        {{ $message->sender->name }} - {{ $message->created_at->format('M d, h:i A') }}
                                    </small>
                                    
                                    @if($message->type == 'image')
                                        <div class="mb-2">
                                            <a href="{{ $message->attachment_path }}" target="_blank">
                                                <img src="{{ $message->attachment_path }}" alt="Attachment" class="img-fluid rounded" style="max-height: 200px;">
                                            </a>
                                        </div>
                                    @endif

                                    @if($message->body)
                                        <div>{{ $message->body }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
