@extends('layouts.app')

@section('title', 'Users List')

@section('content')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>


<div class="nftmax-table mg-top-40">
<div class="panel-body table-responsive">
<div class="panel-body table-responsive">
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h2>Users</h2>

        <table id="users-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
</div>
    @endsection

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.index') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'username', name: 'username' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'role.name', name: 'role.name' },
                    { data: 'approved', name: 'approved', render: function(data) {
                        return data ? 'Approved' : 'Disapproved';
                    }},
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                responsive: true
            });
        });
         $(document).ready(function() {
        $('#users-table').DataTable();
    });
    </script>
    @endpush


