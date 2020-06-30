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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">JekDon - Order</h6>
                                <h2 class="mb-0">Order PMI</h2>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route($route.'create') }}" class="btn btn-success">Tambah</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table align-items-center border" id="data-table">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th width="5%" scope="col">No</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Number</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Telephone</th>
                                        <th scope="col">Status</th>
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
            var url_ajax = '{!! route('admin.jekdon.order.getdata') !!}';
            var column = [
                        { data: 'no', name: 'no' },
                        { data: 'order_code', name: 'order_code' },
                        { data: 'order_number', name: 'order_number' },
                        { data: 'driver.driver_nama', name: 'driver.driver_nama' },
                        { data: 'rumah_sakit.rs_address', name: 'rumah_sakit.rs_address' },
                        { data: 'order_telepon', name: 'order_telepon' },
                        { data: 'order_status', name: 'order_status' },
                        { data: 'aksi', name: 'aksi' },
                    ];
           global.init_datatable(id_datatable, url_ajax, column);
        });
    </script>
@endpush