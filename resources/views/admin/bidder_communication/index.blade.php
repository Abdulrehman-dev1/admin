@extends('layouts.app')

@push('scripts')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


<style>
    /* Modern UI Customizations */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        background: #fff;
    }

    .card-header {
        background-color: #fff;
        border-bottom: 1px solid #eee;
        padding: 20px 25px;
        border-radius: 12px 12px 0 0 !important;
    }

    .card-title {
        font-weight: 700;
        color: #333;
        font-size: 1.25rem;
    }

    .form-label {
        font-weight: 600;
        color: #555;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control, .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--multiple {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 10px 15px;
        height: auto;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .select2-container--default.select2-container--open .select2-selection--single, .select2-container--default.select2-container--open .select2-selection--multiple {
        border-color: #4a90e2;
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    /* Select2 Specifics */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
        padding-left: 0;
        color: #333;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 42px;
    }
    
    .select2-dropdown {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    /* Tabs Styling */
    .nav-tabs {
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 30px;
    }
    
    .nav-tabs .nav-link {
        border: none;
        color: #888;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 8px 8px 0 0;
        transition: color 0.3s;
    }

    .nav-tabs .nav-link:hover {
        color: #4a90e2;
        background: transparent;
    }

    .nav-tabs .nav-link.active {
        color: #4a90e2;
        background-color: transparent;
        border-bottom: 2px solid #4a90e2;
    }

    /* User Template Styling */
    .user-option-template {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 5px 0;
    }
    
    .user-option-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #eee;
    }
    
    .user-option-info {
        display: flex;
        flex-direction: column;
        line-height: 1.2;
    }
    
    .user-option-name {
        font-weight: 600;
        font-size: 14px;
        color: #333;
    }
    
    .user-option-contact {
        font-size: 12px;
        color: #888;
    }

    .btn-primary {
        background-color: #4a90e2;
        border-color: #4a90e2;
        padding: 12px 30px;
        font-weight: 600;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
        transition: transform 0.2s;
    }
    
    .btn-primary:hover {
        background-color: #357abd;
        transform: translateY(-2px);
    }

    /* Summernote tweaks */
    .note-editor.note-frame {
        border-radius: 8px;
        border-color: #e0e0e0;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Customer Outreach (Bidders)</h4>
                @if(session('success'))
                    <div class="alert alert-success mt-3 shadow-sm br-8">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger mt-3 shadow-sm br-8">{{ session('error') }}</div>
                @endif
            </div>
            <div class="card-body p-4">
                <form action="{{ route('bidder-communication.send') }}" method="POST" id="communication-form">
                    @csrf
                    
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="communicationTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="event-tab" data-bs-toggle="tab" data-bs-target="#email-by-events" type="button" role="tab" aria-controls="email-by-events" aria-selected="true">
                                <i class="fa fa-calendar-check-o me-2"></i> Email by Events
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="user-tab" data-bs-toggle="tab" data-bs-target="#email-by-user" type="button" role="tab" aria-controls="email-by-user" aria-selected="false">
                                <i class="fa fa-users me-2"></i> Email by User
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="communicationTabContent">
                        
                        <!-- Tab 1: Email by Events -->
                        <div class="tab-pane fade show active" id="email-by-events" role="tabpanel" aria-labelledby="event-tab">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Event Type</label>
                                    <select id="event-type" class="form-control" name="event_type" style="width: 100%;">
                                        <option value="">Select Event Type</option>
                                        <option value="1_rupee">1 Rupee Products</option>
                                        <option value="auction">Auction Products</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label">Product</label>
                                    <select id="product-select" class="form-control" name="product_id" disabled style="width: 100%;">
                                        <option value="">Select Product</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Bidders</label>
                                    <select id="user-select" class="form-control" name="user_ids[]" multiple disabled required style="width: 100%;">
                                        <!-- Populated dynamically -->
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Email by User -->
                        <div class="tab-pane fade" id="email-by-user" role="tabpanel" aria-labelledby="user-tab">
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">Search Users</label>
                                    <select id="direct-user-select" class="form-control" name="direct_user_ids[]" multiple style="width: 100%;" disabled>
                                        <!-- Populated via AJAX -->
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" required placeholder="Enter message subject..." style="padding: 12px 15px;">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-12">
                            <label class="form-label">Message Body</label>
                            <textarea name="message" id="message-editor" class="form-control" rows="6" required></textarea>
                            <div class="form-text mt-2 text-muted">
                                <i class="fa fa-info-circle"></i> Use <code>@{{user_name}}</code> to insert the user's name dynamically.
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fa fa-paper-plane me-2"></i> Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        
        // --- Initialize Components ---
        
        // Summernote
        $('#message-editor').summernote({
            placeholder: 'Write your message here...',
            tabsize: 2,
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['codeview', 'help']]
            ]
        });

        // Initialize Select2 Generic
        $('#event-type').select2({ placeholder: "Select Event Type", minimumResultsForSearch: Infinity }); // No search for simple dropdown
        $('#product-select').select2({ placeholder: "Select Product" });

        // --- Custom Image Template for Select2 ---
        function formatUser(user) {
            if (!user.id) return user.text;

            // Handle both raw data objects (AJAX) and existing options
            let name = user.text;
            let contact = '';
            let avatarUrl = '/img/avatar-placeholder.png'; // Default path

            // If coming from AJAX data (or loaded options with attributes)
            // Note: Since we are using standard <option> tags mostly, valid data attributes are safer
            // But Select2 objects from AJAX have properties directly.
            
            // For Bidders/Direct User select, we will try to attach data to the option element or use the data object
            
            // Try to pull data from element dataset if available
            if(user.element && user.element.dataset.avatar) {
                avatarUrl = user.element.dataset.avatar;
            } else if (user.avatar) { // From AJAX object directly
                avatarUrl = user.avatar;
            } else if ($(user.element).data('avatar')){
                 avatarUrl = $(user.element).data('avatar');
            }

            // Cleanup name if it has contact info in text
            // Our previous Logic: Name (email)
            let match = name.match(/^(.*) \((.*)\)$/);
            if(match) {
                name = match[1];
                contact = match[2];
            } else if (user.email || user.phone) {
                 contact = user.email || user.phone;
            }

            // Fallback for avatar
            if(!avatarUrl || avatarUrl === 'null' || avatarUrl === '/img/avatar-placeholder.png') {
                 // Use UI Avatars if no image
                 avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random`;
            } else if (!avatarUrl.startsWith('http')) {
                // If relative path, prefix
                // avatarUrl = '/' + avatarUrl; 
                // Adjust based on how you store images. Assuming they might need full path or relative
            }

            let $template = $(
                `<div class="user-option-template">
                    <img src="${avatarUrl}" class="user-option-avatar" onerror="this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=random'">
                    <div class="user-option-info">
                        <span class="user-option-name">${name}</span>
                        <span class="user-option-contact">${contact}</span>
                    </div>
                 </div>`
            );
            return $template;
        }

        // Initialize Bidders Select (Event Tab)
        let $userSelect = $('#user-select').select2({
            placeholder: "Select Bidders",
            templateResult: formatUser,
            templateSelection: formatUser,
            closeOnSelect: false
        });

        // Initialize Direct User Select (User Tab)
        let $directUserSelect = $('#direct-user-select').select2({
            placeholder: "Search and Select Users...",
            templateResult: formatUser,
            templateSelection: formatUser,
            closeOnSelect: false,
            // If using AJAX Search (server-side filtering)
            // But wait, the previous logic was client-side loading ALL users or using AJAX on explicit search input?
            // The previous logic had a separate search input.
            // Modern UI: let Select2 handle the AJAX search directly!
            ajax: {
                url: "{{ route('bidder-communication.search-users') }}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term // Search term
                    };
                },
                processResults: function (data) {
                    // Map data to Select2 expected format
                    return {
                        results: data.map(function(user) {
                            let contact = user.email ? user.email : (user.phone ? user.phone : 'No contact');
                            return {
                                id: user.id,
                                text: `${user.name} (${contact})`,
                                name: user.name,
                                email: user.email,
                                phone: user.phone,
                                avatar: user.profile_pic // Pass avatar for template
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1 // Require 1 char to start searching
        });


        // --- Tab Logic ---
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            let target = $(e.target).data('bs-target');
            
            if (target === '#email-by-events') {
                $('#email-by-events :input').prop('disabled', false);
                // We don't disable #direct-user-select input directly, but we disable the underlying select 
                $('#direct-user-select').prop('disabled', true);
                
                // Re-apply specific logic
                if(!$('#event-type').val()) $('#product-select').prop('disabled', true);
                if(!$('#product-select').val()) $('#user-select').prop('disabled', true);

            } else if (target === '#email-by-user') {
                $('#email-by-events :input').prop('disabled', true);
                $('#direct-user-select').prop('disabled', false);
            }
        });
        
        // Initial State
        $('#direct-user-select').prop('disabled', true);


        // --- Event Tab Logic ---
        $('#event-type').on('change', function() {
            let type = $(this).val();
            let $productSelect = $('#product-select');
            
            $productSelect.empty().trigger('change');
            $('#user-select').empty().trigger('change').prop('disabled', true);

            if (type) {
                // Manually add placeholder
                $productSelect.append(new Option('Loading...', '', false, false));
                
                $.ajax({
                    url: "{{ route('bidder-communication.products') }}",
                    data: { type: type },
                    success: function(data) {
                        $productSelect.empty();
                        $productSelect.append(new Option('Select Product', '', false, false));
                        data.forEach(function(item) {
                            $productSelect.append(new Option(item.title, item.id, false, false));
                        });
                        $productSelect.prop('disabled', false).trigger('change');
                    }
                });
            } else {
                 $productSelect.prop('disabled', true);
            }
        });

        $('#product-select').on('change', function() {
            let productId = $(this).val();
            let $biddersSelect = $('#user-select');
            
            if(!productId) return;

            $biddersSelect.empty().append(new Option('Loading...', '', false, false));

            $.ajax({
                url: "{{ route('bidder-communication.bidders') }}",
                data: { product_id: productId },
                success: function(users) {
                    $biddersSelect.empty();
                    if(users.length === 0) {
                        // $biddersSelect.append(new Option('No bidders found', '', false, false)); 
                         // No option needed, just empty
                    } else {
                        users.forEach(function(user) {
                            let contact = user.email ? user.email : (user.phone ? user.phone : 'No contact');
                            let text = `${user.name} (${contact})`;
                            // Append Option with data attributes for image
                            let newOption = new Option(text, user.id, false, false);
                            $(newOption).data('avatar', user.profile_pic); 
                            $(newOption).attr('data-avatar', user.profile_pic); 
                            $biddersSelect.append(newOption);
                        });
                    }
                    $biddersSelect.prop('disabled', false).trigger('change');
                }
            });
        });

    });
</script>
@endpush
