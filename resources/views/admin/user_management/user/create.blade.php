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
                                <h2 class="mb-0">User</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="RoleName">Username</label>
                                <input type="text" name="user_username" class="form-control" id="RoleName" placeholder="Example : Admin">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Example : *******">
                                <small>
                                    <div>
                                        <i class="ni ni-air-baloon"></i>
                                        <span>Minimum 6 Char</span>
                                    </div>
                                </small>
                            </div>
                            <div class="form-group">
                                <label for="RoleName">UDD Name</label>
                                <div class="row">
                                    @foreach ($udd as $key => $value)
                                        <div class="col-lg-12">
                                            <div class="custom-control custom-control-alternative custom-radio mb-3">
                                            <input class="custom-control-input" name="udd_id" value="{{ $value->id }}" id="udd_id{{ $key }}" type="radio">
                                                <label class="custom-control-label" for="udd_id{{ $key }}">{{ $value->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label> List Role</label>
                                <div class="row">
                                    @foreach ($role as $key => $value)
                                        <div class="col-lg-2">
                                            @foreach ($value as $key_value => $value_role)
                                                <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                                <input class="custom-control-input" name="role_id[]" value="{{ $value_role->id }}" id="customCheck{{$key.$key_value}}" type="checkbox">
                                                    <label class="custom-control-label" for="customCheck{{$key.$key_value}}">{{ $value_role->name }}</label>
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