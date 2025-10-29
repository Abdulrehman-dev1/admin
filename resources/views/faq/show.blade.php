@extends('layouts.app')

@section('content')
<div class="container">
    <h2>FAQ Question Details</h2>
    <p><strong>Category:</strong> {{ $faqQuestion->category->name }}</p>
    <p><strong>Question:</strong> {{ $faqQuestion->question_text }}</p>
    <p><strong>Answer:</strong> {{ $faqQuestion->answer_text }}</p>
    <p><strong>Status:</strong> {{ $faqQuestion->status }}</p>
    <a href="{{ route('faq_questions.index') }}" class="btn btn-primary">Back</a>
</div>
@endsection
