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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Update Data Jenis Donor</h6>
                                <h2 class="mb-0">Update Jenis Donor</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'update_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="driver_id" value="{{ Hashids::encode($data->driver_id) }}">
                            <div class="form-group">
                                <label for="IdDriver">ID Driver</label>
                                <input type="text" value="{{ $data->driver_id }}" class="form-control" id="IdDriver" disabled>
                            </div>
                            <div class="form-group">
                                <label for="NamaDriver">Nama Driver</label>
                                <input type="text" name="driver_nama" value="{{ $data->driver_nama }}" class="form-control" id="NamaDriver">
                            </div>
                            <div class="form-group">
                                <label for="TelpDriver">Telepon Driver</label>
                                <input type="text" name="driver_telp" value="{{ $data->driver_telp }}" class="form-control" id="TelpDriver">
                                {{-- <small>
                                    <div>
                                        <i class="ni ni-air-baloon"></i>
                                        <span>Min / Max 10 Char</span>
                                    </div>
                                </small> --}}
                            </div>
                            <div class="form-group">
                                <label for="EmailDriver">Email Driver</label>
                                <input type="email" name="driver_email" value="{{ $data->driver_email }}" class="form-control" id="EmailDriver">
                            </div>
                            <div class="form-group">
                                <label for="StatusDriver">Status Driver</label>
                                <select class="custom-select" name="driver_status" id="StatusDriver">
                                    @if ($data->driver_status == 'Y')
                                        <option value="Y" selected>Active</option>
                                        <option value="N">Inactive</option>
                                        <option value="X">Block</option>
                                    @elseif ($data->driver_status == 'N')
                                        <option value="Y">Active</option>
                                        <option value="N" selected>Inactive</option>
                                        <option value="X">Block</option>
                                    @elseif ($data->driver_status == 'X')
                                        <option value="Y">Active</option>
                                        <option value="N">Inactive</option>
                                        <option value="X" selected>Block</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="PassDriver">Password Driver</label>
                                <input type="password" name="driver_password" class="form-control" id="PassDriver">
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