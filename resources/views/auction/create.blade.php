@extends('layouts.app')

@section('content')
<div class="container">
    @php $isEdit = isset($auction) && !empty($auction->id); @endphp

    <h1>{{ $isEdit ? 'Edit Auction' : 'Create Auction' }}</h1>

    <form
      action="{{ $isEdit 
          ? route('auctions.update', $auction->id) 
          : route('auctions.store') }}"
      method="POST"
      enctype="multipart/form-data"
      id="auctionForm"
    >
        @csrf

        @if($isEdit)
            @method('PUT')
        @endif

        <!-- Title -->
        <div class="form-group">
            <label for="title">Title</label>
            <input  type="text"
                    name="title"
                    id="title"
                    class="form-control @error('title') is-invalid @enderror"
                    value="{{ old('title', $auction->title ?? '') }}"
                    required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Hidden User -->
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">

        <!-- List Type -->
        <div class="form-group">
            <label for="list_type">List Type</label>
            <select name="list_type" id="list_type" class="form-control" required>
                <option value="auction" {{ old('list_type', $auction->list_type ?? 'auction') == 'auction' ? 'selected' : '' }}>Auction</option>
                <option value="normal_list" {{ old('list_type', $auction->list_type ?? '') == 'normal_list' ? 'selected' : '' }}>Normal List</option>
            </select>
            @error('list_type') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Category / Sub / Child -->
        <div class="row">
            <div class="form-group col-md-4">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                  <option value="">Select Category</option>
                  @foreach($categories as $cat)
                    <option
                      value="{{ $cat->id }}"
                      {{ (old('category_id', $auction->category_id ?? '') == $cat->id) ? 'selected' : '' }}
                    >{{ $cat->name }}</option>
                  @endforeach
                </select>
                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-4" id="subCategoryContainer">
                <label for="sub_category_id">Sub Category</label>
                <select name="sub_category_id" id="sub_category_id" class="form-control" disabled>
                    <option value="">Select Sub Category</option>
                </select>
                @error('sub_category_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-4" id="childCategoryContainer">
                <label for="child_category_id">Child Category</label>
                <select name="child_category_id" id="child_category_id" class="form-control" disabled>
                    <option value="">Select Child Category</option>
                </select>
                @error('child_category_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Create Category (conditional) -->
        <div class="form-group" id="createCategoryContainer" style="display:none;">
            <label for="create_category">Create Category</label>
            <input  type="text"
                    name="create_category"
                    id="create_category"
                    class="form-control @error('create_category') is-invalid @enderror"
                    value="{{ old('create_category', $auction->create_category ?? '') }}">
            @error('create_category') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Existing Album Previews -->
        @if(isset($auction) && !empty($auction->album))
            <div class="form-group">
                <label>Existing Images</label><br>
                @foreach(json_decode($auction->album, true) as $img)
                    <img src="{{ asset(ltrim($img,'/')) }}"
                         alt="Album Image"
                         style="height:80px; margin:5px; object-fit:cover;">
                @endforeach
            </div>
        @endif

        <!-- Album Upload (Auction Only) -->
        <div class="form-group" id="albumContainer">
            <label for="album">Album</label>
            <input  type="file"
                    name="album[]"
                    id="album"
                    class="form-control @error('album') is-invalid @enderror"
                    multiple>
            @error('album') <small class="text-danger">{{ $message }}</small> @enderror
            @if($errors->has('album.*'))
                @foreach($errors->get('album.*') as $errs)
                    @foreach($errs as $err)
                        <small class="text-danger d-block">{{ $err }}</small>
                    @endforeach
                @endforeach
            @endif
        </div>

        <!-- Dates (Auction Only) -->
        <div class="row" id="datesContainer">
            <div class="form-group col-md-6">
                <label for="start_date">Start Date</label>
                <input  type="date"
                        name="start_date"
                        id="start_date"
                        class="form-control @error('start_date') is-invalid @enderror"
                        value="{{ old('start_date', $auction->start_date ?? '') }}"
                        min="{{ date('Y-m-d') }}">
                @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-6">
                <label for="end_date">End Date</label>
                <input  type="date"
                        name="end_date"
                        id="end_date"
                        class="form-control @error('end_date') is-invalid @enderror"
                        value="{{ old('end_date', $auction->end_date ?? '') }}"
                        min="{{ date('Y-m-d') }}">
                @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Pricing & Year (Auction Only) -->
        <div class="row" id="auctionPricingContainer">
            <div class="form-group col-md-4">
                <label for="reserve_price">Reserve Price</label>
                <input  type="number"
                        step="0.01"
                        name="reserve_price"
                        id="reserve_price"
                        class="form-control @error('reserve_price') is-invalid @enderror"
                        value="{{ old('reserve_price', $auction->reserve_price ?? '') }}">
                @error('reserve_price') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="minimum_bid">Minimum Bid</label>
                <input  type="number"
                        step="0.01"
                        name="minimum_bid"
                        id="minimum_bid"
                        class="form-control @error('minimum_bid') is-invalid @enderror"
                        value="{{ old('minimum_bid', $auction->minimum_bid ?? '') }}">
                @error('minimum_bid') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group col-md-4">
                <label for="product_year">Product Year</label>
                <input  type="text"
                        name="product_year"
                        id="product_year"
                        class="form-control @error('product_year') is-invalid @enderror"
                        value="{{ old('product_year', $auction->product_year ?? '') }}">
                @error('product_year') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Normal List Specific Fields -->
        <div id="normalListFields" style="display:none;">
            <!-- Album Upload (Normal List) -->
            <div class="form-group">
                <label for="album_normal">Images</label>
                <input  type="file"
                        name="album[]"
                        id="album_normal"
                        class="form-control @error('album') is-invalid @enderror"
                        multiple>
                @error('album') <small class="text-danger">{{ $message }}</small> @enderror
                @if($errors->has('album.*'))
                    @foreach($errors->get('album.*') as $errs)
                        @foreach($errs as $err)
                            <small class="text-danger d-block">{{ $err }}</small>
                        @endforeach
                    @endforeach
                @endif
            </div>

            <!-- Product Condition -->
            <div class="form-group">
                <label for="product_condition">Product Condition</label>
                <select name="product_condition" id="product_condition" class="form-control">
                    <option value="">Select Condition</option>
                    <option value="new" {{ old('product_condition', $auction->product_condition ?? '') == 'new' ? 'selected' : '' }}>New</option>
                    <option value="old" {{ old('product_condition', $auction->product_condition ?? '') == 'old' ? 'selected' : '' }}>Old</option>
                </select>
                @error('product_condition') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Product Year (Normal List) -->
            <div class="form-group">
                <label for="product_year_normal">Product Year</label>
                <input  type="text"
                        name="product_year"
                        id="product_year_normal"
                        class="form-control @error('product_year') is-invalid @enderror"
                        value="{{ old('product_year', $auction->product_year ?? '') }}">
                @error('product_year') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Price (saves to minimum_bid) -->
            <div class="form-group">
                <label for="price">Price</label>
                <input  type="number"
                        step="0.01"
                        name="minimum_bid"
                        id="price"
                        class="form-control @error('minimum_bid') is-invalid @enderror"
                        value="{{ old('minimum_bid', $auction->minimum_bid ?? '') }}">
                @error('minimum_bid') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <!-- Description -->
       {{-- Description as Code Editor --}}
<div class="form-group">
  <label for="description">Description</label>
<textarea name="description" id="description" class="form-control rich-editor" rows="6">
  {{ old('description', $auction->description ?? '') }}
</textarea>

@error('description') <small class="text-danger">{{ $message }}</small> @enderror
</div>



        <!-- Status & Featured (Both Auction and Normal List) -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="active"   {{ old('status', $auction->status)=='active'? 'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status', $auction->status)=='inactive'? 'selected':'' }}>Inactive</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="featured_name">Featured Name</label>
                <select name="featured_name" id="featured_name" class="form-control">
                    <option value="">-- None --</option>
                    <option value="home_featured"       {{ old('featured_name', $auction->featured_name)=='home_featured'? 'selected':'' }}>Home Featured</option>
                   
                </select>
            </div>
        </div>
        
        
        {{-- Category-specific fields (visible only when category_id == 222) --}}
<div id="cat-222-fields" style="display:none">

  <div class="form-group">
    <label for="developer">Developer <small class="text-muted">(optional)</small></label>
    <input type="text" name="developer" id="developer" class="form-control"
           value="{{ old('developer', $auction->developer ?? '') }}"
           placeholder="Emaar, DAMAC, etc." />
    @error('developer') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label for="location_url">Location URL <span class="text-danger">*</span></label>
    <input type="text" name="location_url" id="location_url" class="form-control"
           value="{{ old('location_url', $auction->location_url ?? '') }}"
           placeholder="https://maps.google.com/?q=..." />
    @error('location_url') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="delivery_date">Delivery date <small class="text-muted">(optional)</small></label>
      <input type="date" name="delivery_date" id="delivery_date" class="form-control"
             value="{{ old('delivery_date', optional($auction->delivery_date ?? null)->format('Y-m-d')) }}" />
      @error('delivery_date') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
    <div class="form-group col-md-6">
      <label for="sale_starts">Sale starts <small class="text-muted">(optional)</small></label>
      <input type="date" name="sale_starts" id="sale_starts" class="form-control"
             value="{{ old('sale_starts', optional($auction->sale_starts ?? null)->format('Y-m-d')) }}" />
      @error('sale_starts') <small class="text-danger">{{ $message }}</small> @enderror
    </div>
  </div>

  <div class="form-group">
    <label for="payment_plan">Payment plan (Code Editor) <small class="text-muted">(optional)</small></label>
<textarea name="payment_plan" id="payment_plan" class="form-control rich-editor" rows="6">
  {{ old('payment_plan', $auction->payment_plan ?? '') }}
</textarea>
    @error('payment_plan') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label for="number_of_buildings">Number of buildings <small class="text-muted">(optional)</small></label>
    <input type="number" min="0" name="number_of_buildings" id="number_of_buildings" class="form-control"
           value="{{ old('number_of_buildings', $auction->number_of_buildings ?? '') }}" />
    @error('number_of_buildings') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label for="government_fee">Government fee (Code Editor) <small class="text-muted">(optional)</small></label>
<textarea name="government_fee" id="government_fee" class="form-control rich-editor" rows="4">
  {{ old('government_fee', $auction->government_fee ?? '') }}
</textarea>    @error('government_fee') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label for="nearby_location">Nearby Location (Code Editor) <small class="text-muted">(optional)</small></label>
<textarea name="nearby_location" id="nearby_location" class="form-control rich-editor" rows="4">
  {{ old('nearby_location', $auction->nearby_location ?? '') }}
</textarea>
    @error('nearby_location') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label for="amenities">Amenities (Code Editor) <small class="text-muted">(optional)</small></label>
<textarea name="amenities" id="amenities" class="form-control rich-editor" rows="4">
  {{ old('amenities', $auction->amenities ?? '') }}
</textarea>
    @error('amenities') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

  <div class="form-group">
    <label for="facilities">Facilities (Code Editor) <small class="text-muted">(optional)</small></label>

<textarea name="facilities" id="facilities" class="form-control rich-editor" rows="4">
  {{ old('facilities', $auction->facilities ?? '') }}
</textarea>    @error('facilities') <small class="text-danger">{{ $message }}</small> @enderror
  </div>

</div>

        <!-- Submit -->
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">
                {{ isset($auction) ? 'Update' : 'Create' }}
            </button>
        </div>
    </form>
</div>

<!-- jQuery + Form Logic -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
// List Type Toggle Function
function toggleListTypeFields() {
    const listType = document.getElementById('list_type').value;
    const isAuction = listType === 'auction';
    const isNormalList = listType === 'normal_list';

    // Auction fields
    const albumContainer = document.getElementById('albumContainer');
    const datesContainer = document.getElementById('datesContainer');
    const auctionPricingContainer = document.getElementById('auctionPricingContainer');
    const cat222Fields = document.getElementById('cat-222-fields');

    // Normal List fields
    const normalListFields = document.getElementById('normalListFields');

    // Show/Hide Auction fields
    if (albumContainer) albumContainer.style.display = isAuction ? 'block' : 'none';
    if (datesContainer) datesContainer.style.display = isAuction ? 'flex' : 'none';
    if (auctionPricingContainer) auctionPricingContainer.style.display = isAuction ? 'flex' : 'none';
    if (cat222Fields) cat222Fields.style.display = (isAuction && parseInt(document.getElementById('category_id').value) === 222) ? 'block' : 'none';

    // Show/Hide Normal List fields
    if (normalListFields) normalListFields.style.display = isNormalList ? 'block' : 'none';
    
    // Hide auction album field when normal list is selected (normal list has its own)
    const albumNormal = document.getElementById('album_normal');
    if (albumNormal && albumContainer) {
        // Both fields exist, just control visibility
    }

    // Handle required attributes
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const reservePrice = document.getElementById('reserve_price');
    const minimumBidAuction = document.getElementById('minimum_bid');
    const productYearAuction = document.getElementById('product_year');
    const priceNormal = document.getElementById('price');
    const productYearNormal = document.getElementById('product_year_normal');
    const productCondition = document.getElementById('product_condition');
    const statusField = document.getElementById('status');

    if (isAuction) {
        if (startDate) startDate.setAttribute('required', 'required');
        if (endDate) endDate.setAttribute('required', 'required');
        if (reservePrice) reservePrice.setAttribute('required', 'required');
        if (minimumBidAuction) minimumBidAuction.setAttribute('required', 'required');
        if (productYearAuction) productYearAuction.setAttribute('required', 'required');
        if (priceNormal) priceNormal.removeAttribute('required');
        if (productYearNormal) productYearNormal.removeAttribute('required');
        if (productCondition) productCondition.removeAttribute('required');
        if (statusField) statusField.setAttribute('required', 'required');
    } else if (isNormalList) {
        if (startDate) startDate.removeAttribute('required');
        if (endDate) endDate.removeAttribute('required');
        if (reservePrice) reservePrice.removeAttribute('required');
        if (minimumBidAuction) minimumBidAuction.removeAttribute('required');
        if (productYearAuction) productYearAuction.removeAttribute('required');
        if (priceNormal) priceNormal.setAttribute('required', 'required');
        if (productYearNormal) productYearNormal.setAttribute('required', 'required');
        if (productCondition) productCondition.setAttribute('required', 'required');
        // Status is optional for normal_list (will be set to active by default if not provided)
        if (statusField) statusField.removeAttribute('required');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const listTypeSelect = document.getElementById('list_type');
    if (listTypeSelect) {
        listTypeSelect.addEventListener('change', toggleListTypeFields);
        toggleListTypeFields(); // Initial call
    }
});

// Category toggle
const CAT_222 = 222;
const catSelect   = document.getElementById('category_id');
const catSection  = document.getElementById('cat-222-fields');
const locationUrl = document.getElementById('location_url');

// ensure it's NEVER required
if (locationUrl) locationUrl.removeAttribute('required');

function applyCategoryUI() {
  const val  = parseInt(catSelect?.value || '0', 10);
  const listType = document.getElementById('list_type').value;
  const show = (val === CAT_222 && listType === 'auction');

  if (catSection) catSection.style.display = show ? '' : 'none';

  // keep not required regardless of category
  if (locationUrl) locationUrl.removeAttribute('required');
}

if (catSelect) {
  catSelect.addEventListener('change', function() {
    applyCategoryUI();
    // Also trigger list type toggle if needed
    if (document.getElementById('list_type').value === 'auction') {
      toggleListTypeFields();
    }
  });
  // initial load
  applyCategoryUI();
}
</script>

<script>
$(function() {
  var oldCategory      = "{{ old('category_id', $auction->category_id ?? '') }}";
  var oldSubcategory   = "{{ old('sub_category_id', $auction->sub_category_id ?? '') }}";
  var oldChildCategory = "{{ old('child_category_id', $auction->child_category_id ?? '') }}";

  function toggleCreateCategory() {
    var cid = Number($('#category_id').val());
    var listType = $('#list_type').val();
    // Show create category for both auction and normal_list when category is 213,214,215,216
    if ([213,214,215,216].includes(cid)) {
      $('#createCategoryContainer').show();
    } else {
      $('#createCategoryContainer').hide().find('input').val('');
    }
  }

  // Also trigger on list_type change
  $('#list_type').on('change', function(){
    toggleCreateCategory();
    toggleListTypeFields();
  });

  $('#category_id').on('change', function(){
    toggleCreateCategory();

    var cid = $(this).val();
    $('#sub_category_id')
      .html('<option value="">Select Sub Category</option>')
      .prop('disabled', true);

    $('#child_category_id')
      .html('<option value="">Select Child Category</option>')
      .prop('disabled', true);

    if (cid) {
      $.get(`/get-subcategories/${cid}`, function(data){
        if (data.subcategories?.length) {
          $('#sub_category_id').prop('disabled', false);
          data.subcategories.forEach(sc => {
            $('#sub_category_id')
              .append(`<option value="${sc.id}">${sc.name}</option>`);
          });
          if (oldSubcategory) {
            $('#sub_category_id').val(oldSubcategory).trigger('change');
          }
        }
      });
    }
  });

  $('#sub_category_id').on('change', function(){
    var scid = $(this).val();
    $('#child_category_id')
      .html('<option value="">Select Child Category</option>')
      .prop('disabled', true);

    if (scid) {
      $.get(`/get-children/${scid}`, function(data){
        if (data.subcategories?.length) {
          $('#child_category_id').prop('disabled', false);
          data.subcategories.forEach(ch => {
            $('#child_category_id')
              .append(`<option value="${ch.id}">${ch.name}</option>`);
          });
          if (oldChildCategory) {
            $('#child_category_id').val(oldChildCategory);
          }
        }
      });
    }
  });

  toggleCreateCategory();
  $('#category_id').trigger('change');
});
</script>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
(function () {
  const editors = []; // [{ editor, el }]
  const $$ = (sel, root=document) => Array.from(root.querySelectorAll(sel));

  // sab textareas jinke upar editor chahiye
  $$('.rich-editor').forEach(el => {
    ClassicEditor.create(el, {
      // yahan blog jaisi toolbar/plugins add kar sakte ho
    })
    .then(editor => {
      // 1) har change par textarea sync
      editor.model.document.on('change:data', () => {
        el.value = editor.getData();
      });

      // 2) array me store
      editors.push({ editor, el });

      // 3) initial sync (agar edit form hai to)
      el.value = editor.getData();
    })
    .catch(err => console.error('CKE init error:', err));
  });

  // 4) form submit par force-sync (belt & suspenders)
  const form = document.getElementById('auctionForm');
  if (form) {
    form.addEventListener('submit', () => {
      editors.forEach(({ editor, el }) => {
        el.value = editor.getData();
      });
    });
  }

  // (optional) agar category toggle show/hide karte ho:
  window.xbRefreshEditors = function () {
    // CKEditor 5 ko usually refresh ki zarurat nahi hoti, but for safety:
    setTimeout(() => {
      editors.forEach(({ editor, el }) => {
        el.value = editor.getData();
      });
    }, 0);
  };
})();
</script>
@endpush


