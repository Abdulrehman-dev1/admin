@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($auction) ? 'View Identity Verification' : 'Create Identity Verification' }}</h1>

    <form action="{{ isset($auction) ? route('auctions.update', $auction->id) : route('auctions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($auction))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                   value="{{ old('title', $auction->title ?? '') }}" required>
            @error('title')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        <!-- Sell Type Selector -->
        <div class="form-group">
            <label for="sellTypeSelect">Select Sell Type</label>
            <select id="sellTypeSelect" class="form-control">
                <option value="all">All Sell</option>
                <option value="vehicle">Vehicle Sell</option>
                <option value="service">Service Sell</option>
                <option value="realstate">Realstate Sell</option>
            </select>
        </div>

        <div class="row">
            <!-- Category Selection (Populated Dynamically) -->
            <div class="form-group col-6">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    <!-- Options will be added via JavaScript -->
                </select>
            </div>

            <!-- Subcategory Selection (Only for All Sell) -->
            <div class="form-group col-6" id="subCategoryContainer">
                <label for="sub_category_id">Sub Category</label>
                <select name="sub_category_id" id="sub_category_id" class="form-control" disabled >
                    <option value="">Select Sub Category</option>
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Child Category Selection (Only for All Sell) -->
            <div class="form-group col-6" id="childCategoryContainer">
                <label for="child_category_id">Child Category</label>
                <select name="child_category_id" id="child_category_id" class="form-control" disabled >
                    <option value="">Select Child Category</option>
                </select>
            </div>
        </div>
      <div class="form-group" id="createCategoryContainer" style="display: none;">
    <label for="create_category">Create Category</label>
    <input type="text" name="create_category" id="create_category"
           class="form-control @error('create_category') is-invalid @enderror"
           value="{{ old('create_category', $auction->create_category ?? '') }}">
    @error('create_category')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


        <!-- Album Upload -->
        <div class="form-group col-6">
            <label for="album">Album</label>
            <input type="file" name="album[]" id="album" class="form-control @error('album') is-invalid @enderror" multiple required>
            @error('album')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            @if ($errors->has('album.*'))
                @foreach ($errors->get('album.*') as $errorMessages)
                    @foreach ($errorMessages as $errorMessage)
                        <small class="text-danger d-block">{{ $errorMessage }}</small>
                    @endforeach
                @endforeach
            @endif
        </div>

        <div class="row">
            <!-- Start Date -->
            <div class="form-group col-6">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="form-control @error('start_date') is-invalid @enderror"
                       value="{{ old('start_date', $auction->start_date ?? '') }}" min="{{ date('Y-m-d') }}"  required>
                @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- End Date -->
            <div class="form-group col-6">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
                       value="{{ old('end_date', $auction->end_date ?? '') }}" min="{{ date('Y-m-d') }}" required>
                @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row">
            <!-- Reserve Price -->
            <div class="form-group col-4">
                <label for="reserve_price">Reserve Price</label>
                <input type="number" name="reserve_price" id="reserve_price" class="form-control @error('reserve_price') is-invalid @enderror"
                       value="{{ old('reserve_price', $auction->reserve_price ?? '') }}" required>
                @error('reserve_price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Minimum Bid -->
            <div class="form-group col-4">
                <label for="minimum_bid">Minimum Bid</label>
                <input type="number" name="minimum_bid" id="minimum_bid" class="form-control @error('minimum_bid') is-invalid @enderror"
                       value="{{ old('minimum_bid', $auction->minimum_bid ?? '') }}" required>
                @error('minimum_bid')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Product Year -->
            <div class="form-group col-4">
                <label for="product_year">Product Year</label>
                <input type="text" name="product_year" id="product_year" class="form-control @error('product_year') is-invalid @enderror"
                       value="{{ old('product_year', $auction->product_year ?? '') }}" required>
                @error('product_year')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
      
       
        

        <!-- Description -->
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                      rows="4">{{ old('description', $auction->description ?? '') }}</textarea>
            @error('description')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Auction Status -->
        <div class="form-group">
            <label for="status">Auction Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="active" {{ (old('status', $auction->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ (old('status', $auction->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <!-- Featured Name Field -->
        <div class="form-group">
            <label for="featured_name">Featured Name</label>
            <select name="featured_name" id="featured_name" class="form-control" >
                <option value="">Select Featured Name</option>
                <option value="home_featured" {{ old('featured_name', $auction->featured_name ?? '') == 'home_featured' ? 'selected' : '' }}>Home Featured</option>
                <option value="realestate_featured" {{ old('featured_name', $auction->featured_name ?? '') == 'realestate_featured' ? 'selected' : '' }}>Realestate Featured</option>
                <option value="vehicle_featured" {{ old('featured_name', $auction->featured_name ?? '') == 'vehicle_featured' ? 'selected' : '' }}>Vehicle Featured</option>
                <option value="service_featured" {{ old('featured_name', $auction->featured_name ?? '') == 'service_featured' ? 'selected' : '' }}>Service Featured</option>
            </select>
        </div>

        <div class="form-group mt-2">
            <button type="submit" class="btn btn-primary">{{ isset($auction) ? 'Update' : 'Create' }}</button>
        </div>
    </form>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
      function toggleCreateCategory() {
    const categoryId = Number($('#category_id').val());
    if ([213, 214, 215, 216].includes(categoryId)) {
        $('#createCategoryContainer').show();
    } else {
        $('#createCategoryContainer').hide();
        $('#create_category').val('');
    }
}
      $('#category_id').change(function(){
    toggleCreateCategory(); 
});
        var allCategories = @json($categories);

        function filterCategories() {
            var sellType = $('#sellTypeSelect').val();
            var filtered = [];
            if (sellType === "all") {
                filtered = allCategories.filter(function(cat) {
                    return (Number(cat.id) >= 1 && Number(cat.id) <= 181) || Number(cat.id) === 213;
                });
                $('#sub_category_id').prop('disabled', false);
                $('#subCategoryContainer').show();
                $('#childCategoryContainer').show();
            } else if (sellType === "vehicle") {
                filtered = allCategories.filter(function(cat) {
                    return (Number(cat.id) >= 190 && Number(cat.id) <= 200) || Number(cat.id) === 214;
                });
                $('#sub_category_id').prop('disabled', true);
                $('#child_category_id').prop('disabled', true);
                $('#subCategoryContainer').hide();
                $('#childCategoryContainer').hide();
            } else if (sellType === "service") {
                filtered = allCategories.filter(function(cat) {
                    return (Number(cat.id) >= 201 && Number(cat.id) <= 206) || Number(cat.id) === 215;

                });
                $('#sub_category_id').prop('disabled', true);
                $('#child_category_id').prop('disabled', true);
                $('#subCategoryContainer').hide();
                $('#childCategoryContainer').hide();
            } else if (sellType === "realstate") {
                filtered = allCategories.filter(function(cat) {
                    return (Number(cat.id) >= 207 && Number(cat.id) <= 211) || Number(cat.id) === 216;
                });
                $('#sub_category_id').prop('disabled', true);
                $('#child_category_id').prop('disabled', true);
                $('#subCategoryContainer').hide();
                $('#childCategoryContainer').hide();
            }

            var categorySelect = $('#category_id');
            categorySelect.empty();
            categorySelect.append('<option value="">Select Category</option>');
            $.each(filtered, function(index, cat) {
                categorySelect.append('<option value="'+cat.id+'">'+cat.name+'</option>');
            });
        }

        $('#sellTypeSelect').change(function(){
            filterCategories();
        });

        // Initialize on page load
        filterCategories();
toggleCreateCategory(); 

        // Only load subcategories if "All Sell" is selected
        $('#category_id').change(function(){
            let categoryId = $(this).val();
            $('#sub_category_id').html('<option value="">Select Sub Category</option>');
            $('#child_category_id').html('<option value="">Select Child Category</option>').prop('disabled', true);
            if (categoryId && $('#sellTypeSelect').val() === "all") {
                $.ajax({
                    url: `/get-subcategories/${categoryId}`,
                    type: "GET",
                    success: function (data) {
                        if (data.subcategories.length > 0) {
                            $('#sub_category_id').prop('disabled', false);
                            $.each(data.subcategories, function (index, subCategory) {
                                $('#sub_category_id').append('<option value="'+subCategory.id+'">'+subCategory.name+'</option>');
                            });
                        } else {
                            $('#sub_category_id').prop('disabled', true);
                        }
                    }
                });
            }
        });

        $('#sub_category_id').change(function(){
            let subCategoryId = $(this).val();
            $('#child_category_id').html('<option value="">Select Child Category</option>');
            if (subCategoryId) {
                $.ajax({
                    url: `/get-childern/${subCategoryId}`,
                    type: "GET",
                    success: function (data) {
                        if (data.subcategories.length > 0) {
                            $('#child_category_id').prop('disabled', false);
                            $.each(data.subcategories, function (index, childCategory) {
                                $('#child_category_id').append('<option value="'+childCategory.id+'">'+childCategory.name+'</option>');
                            });
                        } else {
                            $('#child_category_id').prop('disabled', true);
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
