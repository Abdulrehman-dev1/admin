@extends('layouts.app')

@section('content')
    <div class="nftmax__container mg-top-40">
        <div class="row">
            <div class="col-12">
                <div class="nftmax-card">
                    <div class="nftmax-card__header d-flex justify-content-between align-items-center">
                        <h4 class="nftmax-card__title">User Details</h4>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                    <div class="nftmax-card__body">
                        <div class="row">
                            <!-- Personal Info -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3 text-primary">Personal Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 150px;">Full Name:</th>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Username:</th>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span
                                                class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Registered On:</th>
                                        <td>{{ $user->created_at->format('d M, Y h:i A') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Location Info -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3 text-primary">Location Details</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 150px;">Country:</th>
                                        <td>{{ $user->country->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>City:</th>
                                        <td>{{ $user->city_id ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td>{{ $user->address ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Business & Extra -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3 text-primary">Business & Extras</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 150px;">Company Name:</th>
                                        <td>{{ $user->company_name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>VAT Number:</th>
                                        <td>{{ $user->vat_number ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Referral Code:</th>
                                        <td>{{ $user->referral_code ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Role:</th>
                                        <td>{{ ucfirst($user->role) }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Tracking Info -->
                            <div class="col-md-6 mb-4">
                                <h5 class="mb-3 text-primary">Tracking Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <th style="width: 150px;">UTM Source:</th>
                                        <td>{{ $user->utm_source ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>UTM Medium:</th>
                                        <td>{{ $user->utm_medium ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>UTM Campaign:</th>
                                        <td>{{ $user->utm_campaign ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection