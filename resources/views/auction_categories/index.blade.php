{{-- resources/views/auction_categories/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Auction Categories     <a class="btn btn-sm btn-info" href="{{route('auction_categories.create')}}">Create Categories</a>
</h1>
    <div class="accordion" id="parentAccordion">
        @foreach($categories as $parent)
            <div class="accordion-item">
                <div class="d-flex justify-content-between align-items-center">
                <h2 class="accordion-header" id="headingParent{{ $parent->id }}">
                    <button class="accordion-button collapsed " 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#collapseParent{{ $parent->id }}" 
                            aria-expanded="false" 
                            aria-controls="collapseParent{{ $parent->id }}">
                       <span class="me-3"> {{ $parent->name }}</span>
                       
                    </button>
                </h2>  <a href="{{ route('auction_categories.edit', $parent->id) }}"
                                                                   class="btn btn-sm btn-primary">Edit</a>
                                                                   </div>
                <div id="collapseParent{{ $parent->id }}"
                     class="accordion-collapse collapse"
                     aria-labelledby="headingParent{{ $parent->id }}"
                     data-bs-parent="#parentAccordion">
                    <div class="accordion-body">

                        <div class="accordion" id="subAccordion{{ $parent->id }}">
                            @foreach($parent->subCategories as $sub)
                                <div class="accordion-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h2 class="accordion-header" id="headingSub{{ $sub->id }}">
                                        <button class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseSub{{ $sub->id }}"
                                                aria-expanded="false"
                                                aria-controls="collapseSub{{ $sub->id }}">
                                            <span class="me-3">{{ $sub->name }}</span>
                                        </button>
                                    </h2>
                                    <a href="{{ route('auction_categories.edit', $sub->id) }}"
                                                                   class="btn btn-sm btn-primary">Edit</a>
</div>
                                    <div id="collapseSub{{ $sub->id }}"
                                         class="accordion-collapse collapse"
                                         aria-labelledby="headingSub{{ $sub->id }}"
                                         data-bs-parent="#subAccordion{{ $parent->id }}">
                                        <div class="accordion-body">

                                            <table class="table nftmax-table">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sub->childCategories as $child)
                                                        <tr>
                                                            <td>{{ $child->id }}</td>
                                                            <td>{{ $child->name }}</td>
                                                            <td class="text-nowrap">
                                                                <a href="{{ route('auction_categories.show', $child->id) }}"
                                                                   class="btn btn-sm btn-info">View</a>
                                                                <a href="{{ route('auction_categories.edit', $child->id) }}"
                                                                   class="btn btn-sm btn-primary">Edit</a>
                                                                <form action="{{ route('auction_categories.destroy', $child->id) }}"
                                                                      method="POST"
                                                                      class="d-inline"
                                                                      onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection