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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Master Data - User Driver</h6>
                                <h2 class="mb-0">Table Master User Driver</h2>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route($route.'create') }}" class="btn btn-sm btn-success">Add Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table align-items-center table-flush" id="data-table">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th width="5%" scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Telpon</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                {{-- <tbody class="text-center">
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <td scope="row">
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $value->driver_nama }}
                                            </td>
                                            <td>
                                                @if ($value->driver_status == 'Y')
                                                    <span class="badge badge-primary">Active</span>
                                                @elseif ($value->driver_status == 'N')
                                                    <span class="badge badge-danger">Inactive</span>
                                                @elseif ($value->driver_status == 'X')
                                                    <span class="badge badge-default">Blocked</span>
                                                @endif    
                                            </td>
                                            <td>
                                                {{ $value->driver_telp }}
                                            </td>
                                            <td>
                                                {{ $value->driver_email }}
                                            </td>
                                            <td>
                                                <a target="_blank" href="https://wa.me/62{{ substr($value->driver_telp, 1).'?text=Info JEKDON Driver %0ATanggal : '.date("Y-m-d").' %0ANama Driver : '.$value->driver_nama.'%0ASilahkan Download Aplikasi di...' }}" class="btn btn-outline-success">Send WhatsApp</a>
                                                <form action="{{ route($route.'delete_action', ['user_driver_id' => Hashids::encode($value->driver_id)]) }}" method="GET" enctype="multipart/form-data" class="form-global-handle">
                                                    <a href="{{ route($route.'update', ['user_driver_id' => Hashids::encode($value->driver_id)]) }}" class="btn btn-outline-warning">Edit</a>
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody> --}}
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
            var url_ajax = '{!! route('admin.master.user_driver.getdata') !!}';
            var column = [
                        { data: 'no', name: 'no' },
                        { data: 'driver_nama', name: 'driver_nama' },
                        { data: 'driver_status', name: 'driver_status' },
                        { data: 'driver_telp', name: 'driver_telp' },
                        { data: 'driver_email', name: 'driver_email' },
                        { data: 'aksi', name: 'aksi' },
                    ];
           global.init_datatable(id_datatable, url_ajax, column);
        });
    </script>
@endpush