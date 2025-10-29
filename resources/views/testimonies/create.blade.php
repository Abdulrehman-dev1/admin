@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($testimony) ? 'Edit' : 'Create' }} Testimony</h2>
    <form method="POST" action="{{ isset($testimony) ? route('testimonies.update', $testimony->id) : route('testimonies.store') }}">
        @csrf
        @if(isset($testimony))
            @method('PATCH')
        @endif

        {{-- User Dropdown --}}
        <div class="form-group">
            <label for="user_id">User</label>
            <span class="text-red">*</span>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ (isset($testimony) && $testimony->user_id == $user->id) ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Testimony Textarea --}}
        <div class="form-group">
            <label for="testimony">Testimony</label>
            <span class="text-red">*</span>
            <textarea name="testimony" id="testimony" class="form-control @error('testimony') is-invalid @enderror" rows="5" required>
                {{ old('testimony', $testimony->testimony ?? '') }}
            </textarea>
            @error('testimony')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Status Dropdown --}}
        <div class="form-group">
            <label for="status">Status</label>
            <span class="text-red">*</span>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="Active" {{ (isset($testimony) && $testimony->status == 'Active') ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ (isset($testimony) && $testimony->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Submit and Cancel Buttons --}}
        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ isset($testimony) ? 'Update' : 'Create' }}</button>
            <a href="{{ route('testimonies.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
