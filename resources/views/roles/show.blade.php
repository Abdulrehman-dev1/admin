@extends('layouts.app')

@section('title', 'Show Role')

@section('content')
       <div class="nftmax__form mg-top-40">
              <div class="nftmax__container">
                     <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="nftmax__form-title mb-0">Show Role</h3>
                            <a class="nftmax__btn primary" href="{{ route('roles.index') }}"> Back</a>
                     </div>

                     <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                   <div class="form-group">
                                          <strong>Name:</strong>
                                          {{ $role->name }}
                                   </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                   <div class="form-group">
                                          <strong>Permissions:</strong>
                                          @if(!empty($rolePermissions))
                                                 @foreach($rolePermissions as $v)
                                                        <label class="badge badge-success">{{ $v->name }}</label>
                                                 @endforeach
                                          @endif
                                   </div>
                            </div>
                     </div>
              </div>
       </div>
@endsection