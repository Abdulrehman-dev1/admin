@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($createLetter) ? 'Edit' : 'Create' }} Letter</h2>
    <form method="POST"
          action="{{ isset($createLetter) ? route('createletters.update', $createLetter->id) : route('createletters.store') }}"
          accept-charset="UTF-8"
          enctype="multipart/form-data"
          name="formValidate"
          novalidate=""
          class="ng-pristine ng-invalid ng-invalid-required ng-valid-minlength ng-valid-maxlength">
        @csrf
        @if (isset($createLetter))
            @method('PUT')
        @endif

        <div class="col-xs-6">

            <div class="form-group">
                <label for="to" class="control-label">To</label>
                <span class="text-red">*</span>
                <select class="form-control select2" name="to" required>
                    <option selected="selected" value="">Select Subscriber</option>
                    <option value="navani.ande152@gmail.com"
                            {{ isset($createLetter) && $createLetter->to == 'navani.ande152@gmail.com' ? 'selected' : '' }}>
                        navani.ande152@gmail.com
                    </option>
                    <option value="andenavani@gmail.com"
                            {{ isset($createLetter) && $createLetter->to == 'andenavani@gmail.com' ? 'selected' : '' }}>
                        andenavani@gmail.com
                    </option>
                    <option value="cstplmanohar@gmail.com"
                            {{ isset($createLetter) && $createLetter->to == 'cstplmanohar@gmail.com' ? 'selected' : '' }}>
                        cstplmanohar@gmail.com
                    </option>
                    <option value="indira.qa+berlin@conquerorstech.net"
                            {{ isset($createLetter) && $createLetter->to == 'indira.qa+berlin@conquerorstech.net' ? 'selected' : '' }}>
                        indira.qa+berlin@conquerorstech.net
                    </option>
                </select>
                @error('to')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="title" class="control-label">Title</label>
                <span class="text-red">*</span>
                <input class="form-control"
                       placeholder="Title"
                       name="title"
                       type="text"
                       required
                       minlength="2"
                       maxlength="50"
                       value="{{ old('title', isset($createLetter) ? $createLetter->title : '') }}">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="message" class="control-label">Message</label>
                <span class="text-red">*</span>
                <textarea class="form-control ckeditor"
                          name="message"
                          cols="50"
                          rows="10">{{ old('message', isset($createLetter) ? $createLetter->message : '') }}</textarea>
                @error('message')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group pull-right">
                <button class="btn btn-success" type="submit">
                    {{ isset($createLetter) ? 'Update' : 'Save' }}
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
