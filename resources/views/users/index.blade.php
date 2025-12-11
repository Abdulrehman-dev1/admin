@extends('layouts.app')

@section('title', 'Users List')

@section('content')



  <style>
    /* The switch container */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    /* Hide default checkbox */
    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    /* The slider */
    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    /* When checked */
    input:checked+.slider {
      background-color: #4caf50;
    }

    input:checked+.slider:before {
      transform: translateX(26px);
    }

    /* Optional: show On/Off text */
    .switch.on .slider:after,
    .switch.off .slider:after {
      content: attr(data-state);
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      font-size: 12px;
      color: white;
      width: 100%;
      text-align: center;
      left: 0;
    }

    /* Custom Pagination Styles */
    .pagination {
      justify-content: space-between;
      margin-top: 20px;
      gap: 6px;
    }

    .page-item .page-link {
      border-radius: 8px !important;
      color: #5356FB;
      border: 1px solid #E3E4E8;
      background: #fff;
      padding: 8px 14px;
      font-weight: 600;
      font-size: 14px;
      box-shadow: none;
    }

    .page-item.active .page-link {
      background-color: #5356FB !important;
      border-color: #5356FB !important;
      color: white !important;
    }

    .page-item.disabled .page-link {
      color: #A0AEC0;
      background-color: #FAFAFB;
      border-color: #E3E4E8;
    }

    .page-link:hover {
      background-color: #F3F4F6;
      color: #5356FB;
    }

    .page-link:focus {
      box-shadow: 0 0 0 0.2rem rgba(83, 86, 251, 0.25);
    }

    /* Hide the 'Showing results' text if it's appearing as a simple text node next to pagination blocks in default views, 
         but if it's separate, we can style standard bootstrap elements. 
         Usually bootstrap-5 view renders a `div` with `d-md-flex`. 
         We target the container to center things properly. */
    .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between {
      /* This is the container class in default Laravel pagination view */
      display: flex !important;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }

    .d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between>div:first-child {
      /* The 'Showing x to y' text container */
      margin-bottom: 5px;
    }
  </style>
  <div class="nftmax-table mg-top-40">
    <div class="row mb-4">
      <div class="col-12">
        <div class="card nftmax-card">
          <div class="card-body">
            <form action="{{ route('users.index') }}" method="GET">
              <div class="row align-items-end">
                <div class="col-md-4">
                  <div class="form-group mb-0">
                    <label for="date_from" class="form-label fw-bold" style="color: #374557; font-size: 14px;">From
                      Date</label>
                    <input type="date" name="date_from" id="date_from" class="form-control"
                      value="{{ request('date_from') }}"
                      style="height: 48px; border-radius: 10px; border: 1px solid #E3E4E8; padding: 10px 15px; background-color: #FAFAFB;">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-0">
                    <label for="date_to" class="form-label fw-bold" style="color: #374557; font-size: 14px;">To
                      Date</label>
                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}"
                      style="height: 48px; border-radius: 10px; border: 1px solid #E3E4E8; padding: 10px 15px; background-color: #FAFAFB;">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group mb-0 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"
                      style="height: 48px; border-radius: 10px; background-color: #5356FB; border: none; font-weight: 600;">
                      <i class="fas fa-filter me-2"></i>Filter
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary w-100"
                      style="height: 48px; border-radius: 10px; background-color: #F3F4F6; color: #374557; border: none; font-weight: 600; display: flex; align-items: center; justify-content: center;">
                      <i class="fas fa-undo me-2"></i>Reset
                    </a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="nftmax__container">
    <div class="nftmax-table__heading">
      <h3 class="nftmax-table__title mb-0">User Management</h3>
      <a href="{{ route('users.create') }}" class="nftmax__btn nftmax__btn--primary btn btn-primary">Add User</a>
    </div>
    <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
      <!-- NFTMax Table Head -->
      <thead class="nftmax-table__head">
        <tr>
          <th class="nftmax-table__column-3 nftmax-table__h3">Name</th>
          <th class="nftmax-table__column-2 nftmax-table__h2">Email</th>
          <th class="nftmax-table__column-3 nftmax-table__h3">Verification</th>
          <th class="nftmax-table__column-4 nftmax-table__h4">Role</th>
          <th class="nftmax-table__column-5 nftmax-table__h5">Block</th>
          <th class="nftmax-table__column-5 nftmax-table__h6">Actions</th>
        </tr>
      </thead>
      <!-- NFTMax Table Body -->
      <tbody class="nftmax-table__body">
        @forelse ($users as $index => $user)
          <tr>
            <td class="nftmax-table__column-3 nftmax-table__data-3">
              <p class="nftmax-table__text">{{ $user->name ?? 'N/A' }}</p>
            </td>
            <td class="nftmax-table__column-2 nftmax-table__data-2">
              <p class="nftmax-table__text">{{ $user->email }}</p>
            </td>

            <td class="nftmax-table__column-4 nftmax-table__data-4">
              @if(($user->IndividualVerification->status ?? '') === 'verified')
                <span class="badge bg-success">Verified</span>
              @else
                <span class="badge bg-warning text-dark">Not Verified</span>
              @endif
            </td>
            <td class="nftmax-table__column-4 nftmax-table__data-4">
              <div class="nftmax-table__status nftmax-gbcolor">{{ $user->role ?? 'User' }}</div>
            </td>
            <td class="nftmax-table__column-5 nftmax-table__data-5">
              <form action="{{ route('user.status.update', $user) }}" method="POST" style="display:inline">
                @csrf

                @php
                  // Checked when status == 'enable'
                  $checked = $user->status === 'enable';
                @endphp

                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="statusSwitch{{ $user->id }}" name="status" {{ $checked ? 'checked' : '' }} onchange="this.form.submit()">
                  <label class="form-check-label" for="statusSwitch{{ $user->id }}">
                    {{ $checked ? 'On' : 'Off' }}
                  </label>
                </div>
              </form>


            </td>
            <td>
              <div class="nftmax__actions ">
                <a href="{{ route('users.show', $user->id) }}" class="nftmax__btn nftmax__btn--view btn btn-primary me-1"
                  style="background-color: #6f42c1; border-color: #6f42c1;">View</a>
                <a href="{{ route('users.edit', $user->id) }}" class="nftmax__btn nftmax__btn--edit btn btn-info">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="nftmax__btn nftmax__btn--delete btn  btn-danger">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="nftmax-table__no-data">No users found.</td>
          </tr>
        @endforelse
      </tbody>
      <!-- End NFTMax Table Body -->
    </table>
    <div class="d-flex justify-content-center mt-4">
      {{ $users->links('pagination::bootstrap-5') }}
    </div>
  </div>
  </div>



  <script>
    const checkbox = document.getElementById('toggleSwitch');
    const wrapper = document.getElementById('mySwitch');
    const slider = wrapper.querySelector('.slider');

    // Initialize state
    function updateState() {
      if (checkbox.checked) {
        wrapper.classList.replace('on', 'off');
        slider.setAttribute('data-state', 'On');
      } else {
        wrapper.classList.replace('on', 'off');
        slider.setAttribute('data-state', 'Off');
      }
    }

    // On load
    updateState();

    // Toggle on click
    checkbox.addEventListener('change', updateState);
  </script>
@endsection