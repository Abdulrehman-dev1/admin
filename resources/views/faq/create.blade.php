@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($faqQuestion) ? 'Edit' : 'Create' }} FAQ Question</h2>
    <form method="POST" action="{{ isset($faqQuestion) ? route('faq_questions.update', $faqQuestion->id) : route('faq_questions.store') }}">
        @csrf
        @if(isset($faqQuestion))
            @method('PUT')
        @endif
        <div class="form-group">
           {{-- <label for="category_id">Faq Category</label>
             <select name="category_id" class="form-control" required>
                <option value="">Select Category</option>
                {{-- @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ isset($faqQuestion) && $faqQuestion->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select> --}}
        </div>

        <div class="form-group">
            <label for="question_text">Question</label>
            <textarea name="question_text" class="form-control" required>{{ isset($faqQuestion) ? $faqQuestion->question_text : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="answer_text">Answer</label>
            <textarea name="answer_text" class="form-control" required>{{ isset($faqQuestion) ? $faqQuestion->answer_text : '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="Active" {{ isset($faqQuestion) && $faqQuestion->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ isset($faqQuestion) && $faqQuestion->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
