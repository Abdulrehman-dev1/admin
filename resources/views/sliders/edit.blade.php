@extends('layouts.app')

@section('content')
<h1>Edit Slider</h1>

<form action="{{ route('sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Slider Category Select Box -->
    <label for="slider_category_id" class="m-0">Slider Category</label>
    <select name="slider_category_id" id="slider_category_id" class="form-control my-2" >
        <option value="">Select a Slider Category</option>
        @foreach($sliderCategories as $category)
            <option value="{{ $category->id }}"
                {{ old('slider_category_id', $slider->slider_category_id) == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    @error('slider_category_id')
        <p>{{ $message }}</p>
    @enderror

    <!-- Other Slider Fields -->
    <label for="" class="m-0">Title</label>
    <input type="text" class="form-control my-2" name="title" value="{{ old('title', $slider->title) }}" required>

    <label for="" class="m-0">Sub Title</label>
    <input type="text" class="form-control my-2" name="subtitle" value="{{ old('subtitle', $slider->subtitle) }}">

    <label for="" class="m-0">Description</label>
    <textarea name="description" class="form-control my-2">{{ old('description', $slider->description) }}</textarea>

    <label for="" class="m-0">Image</label>
    <input type="file" class="form-control my-2" name="image">
    
    <button type="submit" class="btn btn-info my-3 shadow">Update</button>
</form>
@endsection
