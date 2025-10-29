@extends('layouts.app')
 @php


 @endphp
 @endphp($emailTemplate); 
@section('content')
<div class="container">
    <div class="row">
        <h1>{{ isset($emailTemplate) ? 'Edit Email Template' : 'Create Email Template' }}</h1>

       
        <form action="{{ isset($emailTemplate) ? route('emailtemplates.update', $emailTemplate->id) : route('emailtemplates.store') }}" method="POST">
            @csrf
            @if(isset($emailTemplate))
                @method('PUT')
            @endif

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="{{ isset($emailTemplate) ? $emailTemplate->title : '' }}" required>
            </div>

            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" class="form-control">
                    <option value="Content" {{ isset($emailTemplate) && $emailTemplate->type == 'Content' ? 'selected' : '' }}>Content</option>
                    <option value="Header" {{ isset($emailTemplate) && $emailTemplate->type == 'Header' ? 'selected' : '' }}>Header</option>
                    <option value="Footer" {{ isset($emailTemplate) && $emailTemplate->type == 'Footer' ? 'selected' : '' }}>Footer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ isset($emailTemplate) ? $emailTemplate->subject : '' }}" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="content" class="form-control ckeditor">{{ isset($emailTemplate) ? $emailTemplate->content : '' }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
</div>
@endsection
