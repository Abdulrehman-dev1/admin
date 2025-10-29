@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Wallets</h1>

  <table class="table nftmax-table" id="walletsTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Email</th>
        <th>Balance</th>
        <th>Created</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach($wallets as $w)
      <tr data-id="{{ $w->id }}">
        <td>{{ $w->id }}</td>
        <td>{{ optional($w->user)->name }}</td>
		<td>{{ optional($w->user)->email }}</td>
        <td class="balance-cell">{{ number_format($w->balance,2) }}</td>
        <td>{{ $w->created_at->format('Y-m-d') }}</td>
        <td>
          <button 
            class="btn btn-sm btn-warning btn-edit-wallet" 
            data-id="{{ $w->id }}" 
            data-balance="{{ $w->balance }}"
          >
            Edit Balance
          </button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $wallets->links() }}
</div>

{{-- Edit Balance Modal --}}
<div class="modal fade" id="walletModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="walletForm">
      @csrf @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Wallet Balance</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="walletBalance" class="form-label">Balance</label>
            <input 
              type="number" 
              step="0.01" 
              id="walletBalance" 
              name="balance" 
              class="form-control"
            >
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
  $(function(){
    // CSRF for AJAX
    $.ajaxSetup({
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    const modalEl = $('#walletModal');
    const modal   = new bootstrap.Modal(modalEl);
    let currentId = null;

    // Open modal
    $('.btn-edit-wallet').on('click', function(){
      currentId = $(this).data('id');
      $('#walletBalance').val($(this).data('balance'));
      modal.show();
    });

    // Submit AJAX update
    $('#walletForm').on('submit', function(e){
      e.preventDefault();
      const newBal = $('#walletBalance').val();

      $.ajax({
        url: `/wallets/${currentId}`,
        type: 'PUT',
        data: { balance: newBal },
      })
      .done(res => {
        modal.hide();

        // Update table cell
        const row = $(`tr[data-id="${currentId}"]`);
        row.find('.balance-cell')
           .text(parseFloat(res.balance).toFixed(2));

        Swal.fire({
          icon: 'success',
          title: res.message,
          timer: 1200,
          showConfirmButton: false
        });
      })
      .fail(xhr => {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: (xhr.responseJSON?.message || 'Could not update balance')
        });
      });
    });
  });
</script>
@endpush
