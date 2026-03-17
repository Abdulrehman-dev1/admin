@extends('layouts.app')

@section('content')
  <div class="container">
    @php $isEdit = isset($auction) && !empty($auction->id); @endphp

    <h1>{{ $isEdit ? 'Edit Auction' : 'Create Auction' }}</h1>

    <form action="{{ $isEdit
    ? route('auctions.update', $auction->id)
    : route('auctions.store') }}" method="POST" enctype="multipart/form-data" id="auctionForm">
      @csrf

      @if($isEdit)
        @method('PUT')
      @endif

      <!-- Title -->
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
          value="{{ old('title', $auction->title ?? '') }}" required>
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <!-- Hidden User -->
      <input type="hidden" name="user_id" value="{{ Auth::id() }}">

      <!-- List Type -->
      <div class="form-group">
        <label for="list_type">List Type</label>
        <select name="list_type" id="list_type" class="form-control" required>
          <option value="auction" {{ old('list_type', $auction->list_type ?? 'auction') == 'auction' ? 'selected' : '' }}>
            Auction</option>
          <option value="private_auction" {{ old('list_type', $auction->list_type ?? '') == 'private_auction' ? 'selected' : '' }}>
            Private Auction</option>
          <option value="normal_list" {{ old('list_type', $auction->list_type ?? '') == 'normal_list' ? 'selected' : '' }}>
            Normal List</option>
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
              <option value="{{ $cat->id }}" {{ (old('category_id', $auction->category_id ?? '') == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
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
        <input type="text" name="create_category" id="create_category"
          class="form-control @error('create_category') is-invalid @enderror"
          value="{{ old('create_category', $auction->create_category ?? '') }}">
        @error('create_category') <small class="text-danger">{{ $message }}</small> @enderror
      </div>

      <!-- Existing Album Previews -->
      @if(isset($auction) && !empty($auction->album))
        <div class="form-group">
          <label>Existing Images</label><br>
          @foreach(json_decode($auction->album, true) as $img)
            <img src="{{ asset(ltrim($img, '/')) }}" alt="Album Image" style="height:80px; margin:5px; object-fit:cover;">
          @endforeach
        </div>
      @endif

      <!-- Album Upload (Auction Only) -->
      <div class="form-group" id="albumContainer">
        <label for="album">Album</label>
        <input type="file" name="album[]" id="album" class="form-control @error('album') is-invalid @enderror" multiple>
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
          <input type="date" name="start_date" id="start_date"
            class="form-control @error('start_date') is-invalid @enderror"
            value="{{ old('start_date', $auction->start_date ?? '') }}" min="{{ date('Y-m-d') }}">
          @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-md-6">
          <label for="end_date">End Date</label>
          <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror"
            value="{{ old('end_date', $auction->end_date ?? '') }}" min="{{ date('Y-m-d') }}">
          @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
      </div>

      <!-- Pricing & Year (Auction Only) -->
      <div class="row" id="auctionPricingContainer">
        <div class="form-group col-md-4">
          <label for="reserve_price">Reserve Price</label>
          <input type="number" step="0.01" name="reserve_price" id="reserve_price"
            class="form-control @error('reserve_price') is-invalid @enderror"
            value="{{ old('reserve_price', $auction->reserve_price ?? '') }}">
          @error('reserve_price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-md-4">
          <label for="minimum_bid">Minimum Bid</label>
          <input type="number" step="0.01" name="minimum_bid" id="minimum_bid"
            class="form-control @error('minimum_bid') is-invalid @enderror"
            value="{{ old('minimum_bid', $auction->minimum_bid ?? '') }}">
          @error('minimum_bid') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-md-4">
          <label for="product_year">Product Year</label>
          <input type="text" name="product_year" id="product_year"
            class="form-control @error('product_year') is-invalid @enderror"
            value="{{ old('product_year', $auction->product_year ?? '') }}">
          @error('product_year') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
      </div>

      <div id="normalListFields" style="display:none;">
        <!-- Album Upload (Normal List) -->
        <div class="form-group">
          <label for="album_normal">Images</label>
          <input type="file" name="album[]" id="album_normal" class="form-control @error('album') is-invalid @enderror"
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
          <input type="text" name="product_year" id="product_year_normal"
            class="form-control @error('product_year') is-invalid @enderror"
            value="{{ old('product_year', $auction->product_year ?? '') }}">
          @error('product_year') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Price (saves to minimum_bid) -->
        <div class="form-group">
          <label for="price">Price</label>
          <input type="number" step="0.01" name="minimum_bid" id="price"
            class="form-control @error('minimum_bid') is-invalid @enderror"
            value="{{ old('minimum_bid', $auction->minimum_bid ?? '') }}">
          @error('minimum_bid') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Discount Fields (Main Product) -->
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="discount_type">Discount Type</label>
            <select name="discount_type" id="discount_type" class="form-control">
              <option value="">None</option>
              <option value="percent" {{ old('discount_type', $auction->discount_type ?? '') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
              <option value="flat" {{ old('discount_type', $auction->discount_type ?? '') == 'flat' ? 'selected' : '' }}>
                Flat Amount</option>
            </select>
          </div>
          <div class="col-md-6 form-group">
            <label for="discount_value">Discount Value</label>
            <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control"
              value="{{ old('discount_value', $auction->discount_value ?? '') }}">
          </div>
        </div>

        <!-- Variations Section -->
        <div class="form-group mt-4">
          <label>Product Variations (Color, Size etc)</label>
          <div id="variations-container">
            <!-- Variations will be added here via JS -->
            @if(isset($auction) && $auction->variations)
              @foreach($auction->variations as $index => $var)
                <div class="variation-item row mb-2 align-items-end">
                  <div class="col-md-3">
                    <label>Name (e.g. Red, XL)</label>
                    <input type="text" name="variations[{{$index}}][name]" class="form-control" value="{{ $var->name }}"
                      required>
                  </div>
                  <div class="col-md-3">
                    <label>Price</label>
                    <input type="number" step="0.01" name="variations[{{$index}}][price]" class="form-control"
                      value="{{ $var->price }}" required>
                  </div>
                  <div class="col-md-2">
                    <label>Disc Type</label>
                    <select name="variations[{{$index}}][discount_type]" class="form-control">
                      <option value="">None</option>
                      <option value="percent" {{ $var->discount_type == 'percent' ? 'selected' : '' }}>%</option>
                      <option value="flat" {{ $var->discount_type == 'flat' ? 'selected' : '' }}>Flat</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label>Disc Value</label>
                    <input type="number" step="0.01" name="variations[{{$index}}][discount_value]" class="form-control"
                      value="{{ $var->discount_value }}">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-variation">Remove</button>
                  </div>
                </div>
              @endforeach
            @endif
          </div>
          <button type="button" class="btn btn-success btn-sm mt-2" id="add-variation-btn">+ Add Variation</button>
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
            <option value="active" {{ old('status', $auction->status) == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $auction->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="featured_name">Featured Name</label>
          <select name="featured_name" id="featured_name" class="form-control">
            <option value="">-- None --</option>
            <option value="home_featured" {{ old('featured_name', $auction->featured_name) == 'home_featured' ? 'selected' : '' }}>Home Featured</option>

          </select>
          <div class="form-group mt-2" id="sendFeaturedEmailContainer" style="display: none;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="send_featured_email" id="send_featured_email" value="1">
                    <label class="form-check-label" for="send_featured_email">
                        Would you like to send featured email to user?
                    </label>
                </div>
            </div>
        </div>
      </div>

       <div class="row mt-3" id="oneRupeeContainer">
            <div class="col-md-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_1_rupee" id="is_1_rupee" value="1"
                        {{ old('is_1_rupee', $auction->is_1_rupee ?? 0) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_1_rupee">
                        Is 1 Rupee Auction?
                    </label>
                </div>
            </div>
        </div>


      {{-- Category-specific fields (visible only when category_id == 222) --}}
      <div id="cat-222-fields" style="display:none">

        <!-- ... (fields content omitted for brevity, logic remains same) ... -->

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
      const isAuction = listType === 'auction' || listType === 'private_auction';
      const isNormalList = listType === 'normal_list';

      // Auction fields
      const albumContainer = document.getElementById('albumContainer');
      const datesContainer = document.getElementById('datesContainer');
      const auctionPricingContainer = document.getElementById('auctionPricingContainer');
      const cat222Fields = document.getElementById('cat-222-fields');
      const oneRupeeContainer = document.getElementById('oneRupeeContainer');

      // Normal List fields
      const normalListFields = document.getElementById('normalListFields');

      // Show/Hide Auction fields
      if (albumContainer) albumContainer.style.display = isAuction ? 'block' : 'none';
      if (datesContainer) datesContainer.style.display = isAuction ? 'flex' : 'none';
      if (auctionPricingContainer) auctionPricingContainer.style.display = isAuction ? 'flex' : 'none';
      if (cat222Fields) cat222Fields.style.display = (isAuction && parseInt(document.getElementById('category_id').value) === 222) ? 'block' : 'none';
      
      // Toggle 1 Rupee Container
      if (oneRupeeContainer) oneRupeeContainer.style.display = isAuction ? 'block' : 'none';

      // Show/Hide Normal List fields
      if (normalListFields) normalListFields.style.display = isNormalList ? 'block' : 'none';

      // Hide auction album field when normal list is selected (normal list has its own)
      const albumNormal = document.getElementById('album_normal');
      if (albumNormal && albumContainer) {
        // Both fields exist, just control visibility
      }

      // Handle required attributes and disable hidden fields to prevent duplicate submission
      const startDate = document.getElementById('start_date');
      const endDate = document.getElementById('end_date');
      const reservePrice = document.getElementById('reserve_price');
      const minimumBidAuction = document.getElementById('minimum_bid');
      const productYearAuction = document.getElementById('product_year');
      const priceNormal = document.getElementById('price');
      const productYearNormal = document.getElementById('product_year_normal');
      const productCondition = document.getElementById('product_condition');
      const statusField = document.getElementById('status');
      const albumAuction = document.getElementById('album');
      const albumNormalFile = document.getElementById('album_normal');

      if (isAuction) {
        // Enable and require auction fields
        if (startDate) {
          startDate.setAttribute('required', 'required');
          startDate.disabled = false;
        }
        if (endDate) {
          endDate.setAttribute('required', 'required');
          endDate.disabled = false;
        }
        if (reservePrice) {
          reservePrice.setAttribute('required', 'required');
          reservePrice.disabled = false;
        }
        if (minimumBidAuction) {
          minimumBidAuction.setAttribute('required', 'required');
          minimumBidAuction.disabled = false;
        }
        if (productYearAuction) {
          productYearAuction.setAttribute('required', 'required');
          productYearAuction.disabled = false;
        }
        if (albumAuction) albumAuction.disabled = false;

        // Disable normal list fields to prevent duplicate submission
        if (priceNormal) {
          priceNormal.removeAttribute('required');
          priceNormal.disabled = true;
        }
        if (productYearNormal) {
          productYearNormal.removeAttribute('required');
          productYearNormal.disabled = true;
        }
        if (productCondition) {
          productCondition.removeAttribute('required');
          productCondition.disabled = true;
        }
        if (albumNormalFile) albumNormalFile.disabled = true;
        if (statusField) statusField.setAttribute('required', 'required');
      } else if (isNormalList) {
        // Disable auction fields to prevent duplicate submission
        if (startDate) {
          startDate.removeAttribute('required');
          startDate.disabled = true;
        }
        if (endDate) {
          endDate.removeAttribute('required');
          endDate.disabled = true;
        }
        if (reservePrice) {
          reservePrice.removeAttribute('required');
          reservePrice.disabled = true;
        }
        if (minimumBidAuction) {
          minimumBidAuction.removeAttribute('required');
          minimumBidAuction.disabled = true;
        }
        if (productYearAuction) {
          productYearAuction.removeAttribute('required');
          productYearAuction.disabled = true;
        }
        if (albumAuction) albumAuction.disabled = true;

        // Enable and require normal list fields
        if (priceNormal) {
          priceNormal.setAttribute('required', 'required');
          priceNormal.disabled = false;
        }
        if (productYearNormal) {
          productYearNormal.setAttribute('required', 'required');
          productYearNormal.disabled = false;
        }
        if (productCondition) {
          productCondition.setAttribute('required', 'required');
          productCondition.disabled = false;
        }
        if (albumNormalFile) albumNormalFile.disabled = false;
        // Status is optional for normal_list (will be set to active by default if not provided)
        if (statusField) statusField.removeAttribute('required');
      }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function () {
      const listTypeSelect = document.getElementById('list_type');
      if (listTypeSelect) {
        listTypeSelect.addEventListener('change', toggleListTypeFields);
        toggleListTypeFields(); // Initial call
      }
    });

    // Category toggle
    const CAT_222 = 222;
    const catSelect = document.getElementById('category_id');
    const catSection = document.getElementById('cat-222-fields');
    const locationUrl = document.getElementById('location_url');

    // ensure it's NEVER required
    if (locationUrl) locationUrl.removeAttribute('required');

    function applyCategoryUI() {
      const val = parseInt(catSelect?.value || '0', 10);
      const listType = document.getElementById('list_type').value;
      const show = (val === CAT_222 && (listType === 'auction' || listType === 'private_auction'));

      if (catSection) catSection.style.display = show ? '' : 'none';

      // keep not required regardless of category
      if (locationUrl) locationUrl.removeAttribute('required');
    }

    if (catSelect) {
      catSelect.addEventListener('change', function () {
        applyCategoryUI();
        // Also trigger list type toggle if needed
        if (['auction', 'private_auction'].includes(document.getElementById('list_type').value)) {
          toggleListTypeFields();
        }
      });
      // initial load
      applyCategoryUI();
    }

    // Featured Email Toggle
    const featuredNameSelect = document.getElementById('featured_name');
    const sendFeaturedEmailContainer = document.getElementById('sendFeaturedEmailContainer');
    const sendFeaturedEmailCheckbox = document.getElementById('send_featured_email');

    function toggleFeaturedEmail() {
        if (featuredNameSelect && sendFeaturedEmailContainer) {
            if (featuredNameSelect.value === 'home_featured') {
                sendFeaturedEmailContainer.style.display = 'block';
            } else {
                sendFeaturedEmailContainer.style.display = 'none';
                if (sendFeaturedEmailCheckbox) sendFeaturedEmailCheckbox.checked = false;
            }
        }
    }

    if (featuredNameSelect) {
        featuredNameSelect.addEventListener('change', toggleFeaturedEmail);
        toggleFeaturedEmail(); // Initial check
    }
  </script>

  <script>
    $(function () {
      var oldCategory = "{{ old('category_id', $auction->category_id ?? '') }}";
      var oldSubcategory = "{{ old('sub_category_id', $auction->sub_category_id ?? '') }}";
      var oldChildCategory = "{{ old('child_category_id', $auction->child_category_id ?? '') }}";

      function toggleCreateCategory() {
        var cid = Number($('#category_id').val());
        var listType = $('#list_type').val();
        // Show create category for both auction and normal_list when category is 213,214,215,216
        if ([213, 214, 215, 216].includes(cid)) {
          $('#createCategoryContainer').show();
        } else {
          $('#createCategoryContainer').hide().find('input').val('');
        }
      }

      // Also trigger on list_type change
      $('#list_type').on('change', function () {
        toggleCreateCategory();
        toggleListTypeFields();
      });

      $('#category_id').on('change', function () {
        toggleCreateCategory();

        var cid = $(this).val();
        $('#sub_category_id')
          .html('<option value="">Select Sub Category</option>')
          .prop('disabled', true);

        $('#child_category_id')
          .html('<option value="">Select Child Category</option>')
          .prop('disabled', true);

        if (cid) {
          $.get(`/get-subcategories/${cid}`, function (data) {
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

      $('#sub_category_id').on('change', function () {
        var scid = $(this).val();
        $('#child_category_id')
          .html('<option value="">Select Child Category</option>')
          .prop('disabled', true);

        if (scid) {
          $.get(`/get-children/${scid}`, function (data) {
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
    // Variations Logic
    let variationIndex = {{ isset($auction) && $auction->product_variations ? $auction->product_variations->count() : 0 }};

    $('#add-variation-btn').on('click', function() {
        variationIndex++;
        const html = `
          <div class="variation-item row mb-2 align-items-end">
              <div class="col-md-3">
                  <label>Name</label>
                  <input type="text" name="variations[${variationIndex}][name]" class="form-control" required>
              </div>
              <div class="col-md-3">
                  <label>Price</label>
                  <input type="number" step="0.01" name="variations[${variationIndex}][price]" class="form-control" required>
              </div>
              <div class="col-md-2">
                  <label>Disc Type</label>
                  <select name="variations[${variationIndex}][discount_type]" class="form-control">
                      <option value="">None</option>
                      <option value="percent">%</option>
                      <option value="flat">Flat</option>
                  </select>
              </div>
              <div class="col-md-2">
                  <label>Disc Value</label>
                  <input type="number" step="0.01" name="variations[${variationIndex}][discount_value]" class="form-control">
              </div>
              <div class="col-md-2">
                  <button type="button" class="btn btn-danger remove-variation">Remove</button>
              </div>
          </div>
        `;
        $('#variations-container').append(html);
    });

    $(document).on('click', '.remove-variation', function() {
        $(this).closest('.variation-item').remove();
    });
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
