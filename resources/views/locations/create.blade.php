@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($record) ? 'Edit' : 'Add' }} Location</h1>

    <form action="{{ isset($record) ? route('locations.update', ['id' => $record->id, 'type' => $type]) : route('locations.store') }}" method="POST">
        @csrf
        @if(isset($record))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $record->name ?? '' }}" required>
        </div>

        @if(!isset($record))
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">Select Type</option>
                    <option value="country">Country</option>
                    <option value="state">State</option>
                    <option value="city">City</option>
                </select>
            </div>

            <div class="form-group" id="parent-id-group" style="display: none;">
                <label for="parent_id">Parent</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    <!-- Options dynamically added by JS -->
                </select>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#type').on('change', function() {
            var type = $(this).val();

            if (type === 'state' || type === 'city') {
                $('#parent-id-group').show();
                $('#parent_id').empty();

                if (type === 'state') {
                    @foreach($countries as $country)
                        $('#parent_id').append('<option value="{{ $country->id }}">{{ $country->name }}</option>');
                    @endforeach
                } else if (type === 'city') {
                    @foreach($countries as $country)
                        @foreach($country->states as $state)
                            $('#parent_id').append('<option value="{{ $state->id }}">{{ $country->name }} - {{ $state->name }}</option>');
                        @endforeach
                    @endforeach
                }
            } else {
                $('#parent-id-group').hide();
                $('#parent_id').empty();
            }
        });
    });
</script>
@endsection
