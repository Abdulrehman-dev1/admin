@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Referral Users</h2>

    <table class="table table-bordered">
       <thead>
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Referral Code</th>
        <th>Referred By</th>
        <th>Referred Count</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
@forelse($users as $user)
    <tr>
        <td>{{ $user->id ?? 'N/A' }}</td>
        <td>{{ $user->name ?? 'N/A' }}</td>
        <td>{{ $user->email ?? 'N/A' }}</td>
        <td>{{ $user->referral_code ?? 'N/A' }}</td>
        <td>
            @if($user->referrer)
                {{ $user->referrer->name ?? 'N/A' }}
            @else
                N/A
            @endif
        </td>
        <td>{{ $user->referrals_count ?? 0 }}</td> 
        <td>
            <a href="{{ route('referrals.show', $user->id) }}" class="btn btn-sm btn-primary">View</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7">No users found.</td>
    </tr>
@endforelse
</tbody>
</table>
    {{ $users->links() }}
</div>
@endsection
