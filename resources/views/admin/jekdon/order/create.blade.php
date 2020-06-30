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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add JekDon Order</h6>
                                <h2 class="mb-0">Order PMI</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="driver">Driver</label>
                                <select class="form-control" name="order_driver_id" id="driver_id">
                                    <option>--- Select Driver ---</option>
                                    @foreach ($driver as $key => $value)
                                        <option value="{{ $value->driver_id }}">{{ $value->driver_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="rs">Rumah Sakit</label>
                                <select class="form-control" name="order_rs_id" id="rs_id">
                                    <option>--- Select Rumah Sakit ---</option>
                                    @foreach ($rs as $key => $value)
                                        <option value="{{ $value->rs_id }}">{{ $value->rs_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group d-none">
                                <label for="">Titik Lokasi</label>
                                <input type="text" name="" class="form-control" id="" >
                            </div>
                            <div class="form-group d-none">
                                <label for="loc">Lokasi</label>
                                <input type="text" name="order_tujuan" class="form-control" id="loc" >
                            </div>
                            <div class="form-group">
                                <label for="tlp">Telepon</label>
                                <input type="number" name="order_telepon" class="form-control" id="tlp" placeholder="Input Phone Number Here ...">
                            </div>
                            <div class="form-group d-none">
                                <label for="">Darah</label>
                                <input type="text" name="" class="form-control" id="">
                            </div>
                            <div class="form-group">
                                <label for="detail">Detail</label>
                                <textarea class="form-control" name="order_description" id="detail" rows="5" placeholder="Input Detail Here ..."></textarea>
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