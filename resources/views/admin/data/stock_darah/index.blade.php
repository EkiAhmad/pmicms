@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.headers.cards')
   {{-- start patern --}}
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header bg-transparent">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Data - Stock Darah</h6>
                                <h2 class="mb-0">Stock Darah</h2>
                            </div>
                            <div class="col text-right">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive ">
                            <table class="table align-items-center border" id="data-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="5%" scope="col">No</th>
                                        <th scope="col">Golongan Darah</th>
                                        <th scope="col">Produk Darah</th>
                                        <th scope="col">Stock Jumlah</th>
                                        <th scope="col">Show</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end pattern- --}}
    
@endsection

@push('js')
     
    <script src="{{ asset('assets') }}/js/blockUI.js"></script>
    <script src="{{ asset('assets') }}/js/sweetalert2.js"></script>
    <script src="{{ asset('assets') }}/js/custom.js"></script>
    <script src="{{ asset('assets') }}/js/custom_datatable.js"></script>

    <script>
        $(document).ready(function () {
            var id_datatable = "#data-table";
            var url_ajax = '{!! route('admin.data.stock_darah.getdata') !!}';
            var column = [
                        { data: 'no', name: 'no' },
                        { data: 'gol_darah.golongan_name', name: 'gol_darah.golongan_name' },
                        { data: 'prod_darah.produk_name', name: 'prod_darah.produk_name' },
                        { data: 'stock_jumlah', name: 'stock_jumlah' },
                        { data: 'show', name: 'show' },
                        { data: 'aksi', name: 'aksi' },
                    ];
           global.init_datatable(id_datatable, url_ajax, column);
        });
    </script>
    
@endpush