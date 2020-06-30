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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">User Management - Permission</h6>
                                <h2 class="mb-0">Add Permission</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="PrefixPermissionName">Prefix Permission Name</label>
                                <input type="text" name="name" class="form-control" id="PrefixPermissionName" placeholder="Example : Admin">
                            </div>
                            <div class="form-group">
                                <label for="PermissionName">Permission Name</label>
                                <div class="row">
                                    @foreach ($roles as $key => $value)
                                        <div class="col-lg-12">
                                            <div class="custom-control custom-control-alternative custom-checkbox mb-3">
                                            <input class="custom-control-input" name="roles[]" value="{{ $value }}" id="customCheck{{$key}}" type="checkbox">
                                                <label class="custom-control-label" for="customCheck{{$key}}">{{ $value }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                             <div class="group">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <a class="btn btn-default bg-back" href="{{ route($route.'index') }}">Kembali</a>
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