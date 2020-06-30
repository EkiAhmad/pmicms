@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.headers.cards')
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add User Management</h6>
                                <h2 class="mb-0">Add Role Management</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="RoleName">Role Name</label>
                                <input type="text" name="name" class="form-control" id="RoleName" placeholder="Example : Admin">
                            </div>
                            <div class="form-group">
                                <label> List Permission</label>
                                <div class="row">
                                    @foreach ($data as $key => $value)
                                        <div class="col-lg-2">
                                            @foreach ($value as $key_value => $value_data)
                                                <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                                <input class="custom-control-input" name="permission_id[]" value="{{ $value_data->id }}" id="customCheck{{$key.$key_value}}" type="checkbox">
                                                    <label class="custom-control-label" for="customCheck{{$key.$key_value}}">{{ $value_data->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="group">
                                <button type="submit" class="btn btn-outline-success">Save</button>
                                <a class="btn btn-outline-info" href="{{ route($route.'index') }}">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

 {{-- load JS yang lu perluin, selain itu no --}}
@push('js')
    <script src="{{ asset('assets') }}/js/blockUI.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.js"></script>
    <script src="{{ asset('assets') }}/js/custom.js"></script>
@endpush