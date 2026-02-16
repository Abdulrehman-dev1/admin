@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom bg-white">
                    <h4 class="card-title">Chat Management</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Participants</th>
                                    <th>Product</th>
                                    <th>Messages</th>
                                    <th>Last Updated</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conversations as $conversation)
                                <tr>
                                    <td>{{ $conversation->id }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $conversation->userOne->name ?? 'User 1' }}</span>
                                        <i class="fas fa-arrows-alt-h mx-2"></i>
                                        <span class="badge bg-secondary">{{ $conversation->userTwo->name ?? 'User 2' }}</span>
                                    </td>
                                    <td>
                                        @if($conversation->product)
                                            <a href="{{ route('auctions.show', $conversation->product->id) }}" target="_blank">
                                                {{ $conversation->product->title ?? 'Product' }}
                                            </a>
                                        @else
                                            <span class="text-muted">General</span>
                                        @endif
                                    </td>
                                    <td>{{ $conversation->messages_count }}</td>
                                    <td>{{ $conversation->updated_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.chats.show', $conversation->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View Chat
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $conversations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
