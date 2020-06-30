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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Update JekDon</h6>
                                <h2 class="mb-0">Update Order</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'update_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ Hashids::encode($data->order_id) }}">
                            <div class="form-group">
                                <label for="">Order id</label>
                                <input type="text" value="{{ $data->order_id }}" class="form-control" style="cursor: not-allowed;" disabled id="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Current Driver</label>
                                <input type="text" value="{{ $data->driver->driver_nama }}" class="form-control" style="cursor: not-allowed;" disabled id="" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="">Ganti Driver</label>
                                <select class="form-control" name="order_driver_id" id="driver_id">
                                    <option value="{{ $data->driver->driver_id }}">{{ $data->driver->driver_nama }}</option>
                                    @foreach ($driver->where('driver_id','!=', $data->driver_id) as $key => $value)
                                        <option value="{{ $value->driver_id }}">{{ $value->driver_nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Rumah Sakit</label>
                                <select class="form-control" name="order_rs_id" id="rs_id">
                                    <option value="{{ $data->rumah_sakit->rs_id }}">{{ $data->rumah_sakit->rs_name }}</option>
                                    @foreach ($rs->where('rs_id','!=', $data->rs_id) as $key => $value)
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
                                <input type="text" name="order_tujuan" value="{{ $data->order_tujuan }}" class="form-control" id="loc" placeholder="Example : PMI.KAB TANGERANG">
                            </div>
                            <div class="form-group">
                                <label for="tlp">Order Telepon</label>
                                <input type="text" name="order_telepon" class="form-control" id="tlp" value="{{ $data->order_telepon }}" placeholder="Example : 3603">
                            </div>
                            <div class="form-group d-none">
                                <label for="">Darah</label>
                                <input type="text" name="" class="form-control" id="">
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