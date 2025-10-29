@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Payment Requests</h1>
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif


  <table class="table nftmax-table" id="paymentRequestsTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>User</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Status</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($requests as $req)
      <tr>
        <td>{{ $req->id }}</td>
        <td>{{ ($req->user->name) ?? '' }}</td>
        <td>{{ (number_format($req->amount,2)) ?? '' }}</td>
        <td>{{ ($req->paymentMethod->name) ?? '' }}</td>
        <td>{{ (ucfirst($req->status)) ?? '' }}</td>
        <td>{{ ($req->created_at->format('Y-m-d')) ?? '' }}</td>
        <td>
          
		  <button type="button" class="btn btn-sm btn-warning btn-open-status-modal" data-id="{{ $req->id }}" data-status="{{ $req->status }}" > Change Status </button>
          
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  {{ $requests->links() }}
</div>
<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="statusForm" method="POST">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="statusModalLabel">Update Payment Request Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="statusSelect" class="form-label">Status</label>
            <select name="status" id="statusSelect" class="form-select">
              <option value="pending">Pending</option>
              <option value="processing">Processing</option>
              <option value="rejected">Rejected</option>
			  <option value="completed">Completed</option>
            </select>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
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
    // set up CSRF header for all AJAX
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    const statusModal = new bootstrap.Modal($('#statusModal'));
    let currentId = null;

    // open modal
    $('.btn-open-status-modal').on('click', function(){
      currentId = $(this).data('id');
      const currentStatus = $(this).data('status');
      $('#statusSelect').val(currentStatus);
      statusModal.show();
    });

    // handle save via AJAX
    $('#statusForm').on('submit', function(e){
      e.preventDefault();
      const newStatus = $('#statusSelect').val();

      $.ajax({
        url: `payment-requests/${currentId}`,   // route: payment-requests.update
        type: 'PUT',                             // HTTP method
        data: { status: newStatus },             // only sending status
      })
      .done(function(res){
        // hide modal
        statusModal.hide();
        // update the status cell in the row
        $(`button[data-id="${currentId}"]`)
          .closest('tr')
          .find('td:nth-child(5)') // adjust if your status is in a different column
          .text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));

        // update the data-status on the button
        $(`button[data-id="${currentId}"]`).data('status', newStatus);

        // optional: toast or alert
        Swal.fire({
          icon: 'success',
          title: 'Status updated',
          timer: 1500,
          showConfirmButton: false
        });
      })
      .fail(function(xhr){
        // show error
        Swal.fire({
          icon: 'error',
          title: 'Oops',
          text: xhr.responseJSON?.message || 'Unable to update status.'
        });
      });
    });
  });

$(function(){
 
  $('#paymentRequestsTable').DataTable({
    paging: false,
    info: false,
    searching: true
  });

  // SweetAlert for delete
  $('#paymentRequestsTable').on('click', '.btn-delete', function(e){
    e.preventDefault();
    const form = $(this).closest('form');
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      }
    });
  });
});
</script>
@endpush
