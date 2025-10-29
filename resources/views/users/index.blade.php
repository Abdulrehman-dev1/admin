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
      top: 0; left: 0; right: 0; bottom: 0;
      background-color: #ccc;
      transition: 0.4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px; width: 26px;
      left: 4px; bottom: 4px;
      background-color: white;
      transition: 0.4s;
      border-radius: 50%;
    }

    /* When checked */
    input:checked + .slider {
      background-color: #4caf50;
    }
    input:checked + .slider:before {
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
  </style>
<div class="nftmax-table mg-top-40">
<div class="nftmax__container">

    <div class="nftmax-table__heading"><h3 class="nftmax-table__title mb-0">Auctions</h3>
    <a href="{{ route('users.create') }}" class="nftmax__btn nftmax__btn--primary btn btn-primary">Add User</a>
    </div>
    <table id="nftmax-table__main" class="nftmax-table__main nftmax-table__product-history">
        <!-- NFTMax Table Head -->
        <thead class="nftmax-table__head">
            <tr>
                <th class="nftmax-table__column-1 nftmax-table__h1">#</th>
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
                <td class="nftmax-table__column-1 nftmax-table__data-1">
                    <span class="nftmax-table__text"><b>{{ $index + 1 }}</b></span>
                </td>
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
                <form 
  action="{{ route('user.status.update', $user) }}" 
  method="POST"
  style="display:inline"
>
  @csrf

  @php
    // Checked when status == 'enable'
    $checked = $user->status === 'enable';
  @endphp

  <div class="form-check form-switch">
    <input
      class="form-check-input"
      type="checkbox"
      id="statusSwitch{{ $user->id }}"
      name="status"
      {{ $checked ? 'checked' : '' }}
      onchange="this.form.submit()"
    >
    <label 
      class="form-check-label" 
      for="statusSwitch{{ $user->id }}"
    >
      {{ $checked ? 'On' : 'Off' }}
    </label>
  </div>
</form>
                     
                    
                </td>
                <td>
                    <div class="nftmax__actions ">
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
</div>
</div>



<script>
    const checkbox = document.getElementById('toggleSwitch');
    const wrapper  = document.getElementById('mySwitch');
    const slider   = wrapper.querySelector('.slider');

    // Initialize state
    function updateState() {
      if (checkbox.checked) {
        wrapper.classList.replace('on','off');
        slider.setAttribute('data-state','On');
      } else {
        wrapper.classList.replace('on','off');
        slider.setAttribute('data-state','Off');
      }
    }

    // On load
    updateState();

    // Toggle on click
    checkbox.addEventListener('change', updateState);
  </script>
@endsection
