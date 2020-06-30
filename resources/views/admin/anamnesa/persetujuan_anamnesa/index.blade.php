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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Anamnesa Data - Anamnesa Approval</h6>
                                <h2 class="mb-0">Table Anamnesa Approval</h2>
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
                                        <th scope="col">Content</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                {{-- <tbody class="text-left">
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <td scope="row">
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {!! Helper::short_text($value->persetujuan_content, 5000) !!}
                                            </td>
                                            <td>
                                                {{ $value->persetujuan_tipe }}
                                            </td>
                                            <td>
                                                <form action="{{ route($route.'delete_action', ['persetujuan_id' => Hashids::encode($value->persetujuan_id)]) }}" method="GET" enctype="multipart/form-data" class="form-global-handle">
                                                    <a href="{{ route($route.'update', ['persetujuan_id' => Hashids::encode($value->persetujuan_id)]) }}" class="btn btn-outline-warning">Edit</a>
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
            var url_ajax = '{!! route('admin.anamnesa.persetujuan_anamnesa.getdata') !!}';
            var column = [
                        { data: 'no', name: 'no' },
                        { data: 'persetujuan_content', name: 'persetujuan_content' },
                        { data: 'aksi', name: 'aksi' },
                    ];
           global.init_datatable(id_datatable, url_ajax, column);
        });
    </script>
@endpush