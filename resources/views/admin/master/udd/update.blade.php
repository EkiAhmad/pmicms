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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Update User Management</h6>
                                <h2 class="mb-0">Update user</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'update_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ Hashids::encode($data->id) }}">
                            <div class="form-group">
                                <label for="RoleName">Role Name</label>
                                <input type="text" name="name" value="{{ $data->name }}" class="form-control" id="RoleName" placeholder="Example : PMI.KAB TANGERANG">
                            </div>
                            <div class="form-group">
                                <label for="CodeUdd">Code UDD</label>
                                <input type="text" name="kode_udd" class="form-control" id="CodeUdd" value="{{ $data->kode_udd }}" placeholder="Example : 3603">
                                <small>
                                    <div>
                                        <i class="ni ni-air-baloon"></i>
                                        <span>Min / Max 4 Char</span>
                                    </div>
                                </small>
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