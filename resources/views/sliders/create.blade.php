@extends('layouts.app')

@section('content')
<h1>Create Slider</h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('sliders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Slider Category Select Box -->
    <label for="slider_category_id" class="m-0">Slider Category</label>
<select name="slider_category_id" id="slider_category_id" class="form-control my-2" >
    <option value="">Select a Slider Category</option>
    @foreach ($sliderCategories as $category)
        <option value="{{ $category->id }}" {{ old('slider_category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</select>
@error('slider_category_id')
    <p>{{ $message }}</p>
@enderror

    <!-- Other Slider Fields -->
    <label for="title" class="m-0">Title</label>
    <input type="text" name="title" id="title" placeholder="Title" class="form-control my-2" value="{{ old('title') }}" required>
    @error('title')
        <p>{{ $message }}</p>
    @enderror

    <label for="subtitle" class="m-0">Sub Title</label>
    <input type="text" name="subtitle" id="subtitle" placeholder="Subtitle" class="form-control my-2" value="{{ old('subtitle') }}">
    @error('subtitle')
        <p>{{ $message }}</p>
    @enderror

    <label for="description" class="m-0">Description</label>
    <textarea name="description" id="description" placeholder="Description" class="form-control my-2">{{ old('description') }}</textarea>
    @error('description')
        <p>{{ $message }}</p>
    @enderror

    <label for="image" class="m-0">Image</label>
    <input type="file" name="image" id="image" class="form-control my-2">
    @error('image')
        <p>{{ $message }}</p>
    @enderror

    <button type="submit" class="btn btn-info">Create</button>
</form>
@endsection
