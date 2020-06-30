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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Update Data Stock Darah</h6>
                                <h2 class="mb-0">Stock Darah</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'update_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="stock_id" value="{{ Hashids::encode($data->stock_id) }}">

                            <div class="form-group">
                                <label for="Golongan_Darah">Golongan Darah</label>
                                <input type="text" name="stock_golongan_darah_id" id="Golongan_Darah" value="{{ $data->gol_darah->golongan_name }}" class="form-control" disabled>
                            </div>

                            <div class="form-group">
                                <label for="Produk_Darah">Produk Darah</label>
                                <input type="text" name="stock_golongan_darah_id" id="Produk_Darah" value="{{ $data->prod_darah->produk_name }}" class="form-control" disabled>
                            </div>

                            <div class="form-group">
                                <label for="Stock_jumlah">Stock Jumlah</label>
                                <input type="text" name="stock_jumlah" id="Stock_jumlah" class="form-control" value="{{ $data->stock_jumlah }}">
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