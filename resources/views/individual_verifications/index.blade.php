@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Individual Verifications</h2>
  
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
              <th>User Name</th>
                <th>User Email</th>
                <th>Name</th>
                
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($verifications as $item)
            <tr> 
              <td>{{ $item->id }}</td>
              <td>{{ optional($item->user)->name }}</td>
              <td>{{ optional($item->user)->email }}</td>
              <!--<td>-->
              <!--      <img src="{{ asset($item->id_front_path) }}" alt="Front" width="50" class="img-thumbnail img-modal" data-img="{{ asset($item->id_front_path) }}">-->
              <!--  </td>-->
              <!--  <td>-->
              <!--      <img src="{{ asset($item->id_back_path) }}" alt="Back" width="50" class="img-thumbnail img-modal" data-img="{{ asset( $item->id_back_path) }}">-->
              <!--  </td>-->
               
                <td>{{ $item->full_legal_name }}</td>
             <td>
   <div>
  @switch($item->status)
    @case('verified')
      <span class="badge bg-success">Verified</span>
      @break

    @case('not_verified')
      <span class="badge bg-warning text-dark">Not Verified</span>
      @break

    @case('declined')
      <span class="badge bg-danger">Declined</span>
      @break

    @case('resubmit')
      <span class="badge bg-info text-dark">Resubmit</span>
      @break

    @default
      <span class="badge bg-secondary">Unknown</span>
  @endswitch
</div>
</td>
                <td>
      <a href="{{ route('individual-verifications.edit', $item->id) }}"
         class="btn btn-sm btn-info">
        Edit
      </a>

      <form action="{{ route('individual-verifications.destroy', $item->id) }}"
            method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="btn btn-sm btn-danger"
                onclick="return confirm('Delete this record?')">
          Delete
        </button>
      </form>
    </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

{{-- Image Modal --}}
<div id="imgModal" style="display:none;position:fixed;z-index:10000;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.85);align-items:center;justify-content:center;">
    <img id="imgModalSrc" src="" style="max-width:80vw;max-height:80vh;border:8px solid #fff;border-radius:12px;">
</div>
@endsection

@push('scripts')
<script>
    // Click event to show modal
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.img-modal').forEach(function(img){
            img.addEventListener('click', function(){
                document.getElementById('imgModal').style.display = 'flex';
                document.getElementById('imgModalSrc').src = this.getAttribute('data-img');
            });
        });
        // Hide modal on click anywhere
        document.getElementById('imgModal').onclick = function(){
            this.style.display = 'none';
            document.getElementById('imgModalSrc').src = '';
        }
    });
</script>
@endpush
