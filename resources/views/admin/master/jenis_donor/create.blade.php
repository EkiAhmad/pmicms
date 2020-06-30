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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add Master Jenis Donor</h6>
                                <h2 class="mb-0">Jenis Donor</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="JenisName">Jenis Name</label>
                                <input type="text" name="jenis_name" class="form-control" id="JenisName" placeholder="Example : Admin">
                            </div>
                            <div class="form-group">
                                <label for="JenisDesc">Jenis Description</label>
                                <input type="text" name="jenis_description" class="form-control" id="JenisDesc" placeholder="Example : 3603">
                                {{-- <small>
                                    <div>
                                        <i class="ni ni-air-baloon"></i>
                                        <span>Min / Max 4 Char</span>
                                    </div>
                                </small> --}}
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