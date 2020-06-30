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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Anamnesa Data - Anamnesa Question</h6>
                                <h2 class="mb-0">Table Anamnesa Question</h2>
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
                                        <th scope="col">Pertanyaan</th>
                                        <th scope="col">Tipe</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Status</th>
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
                                                {{ $value->pertanyaan_isi }}
                                            </td>
                                            <td>
                                                {{ $value->tipe['tipe_name'] }}
                                            </td>
                                            <td>
                                                {{ $value->kategori['kategori_judul'] }}
                                            </td>
                                            <td>
                                                @if ($value->status == '1' || $value->status == 1 || $value->status == true)
                                                    <span class="badge badge-primary">Tampil</span>
                                                @elseif ($value->status == '0' || $value->status == 0 || $value->status == false)
                                                    <span class="badge badge-danger">Tidak Tampil</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route($route.'delete_action', ['pertanyaan_id' => Hashids::encode($value->pertanyaan_id)]) }}" method="GET" enctype="multipart/form-data" class="form-global-handle">
                                                    <a href="{{ route($route.'update', ['pertanyaan_id' => Hashids::encode($value->pertanyaan_id)]) }}" class="btn btn-outline-warning">Edit</a>
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
            var url_ajax = '{!! route('admin.anamnesa.pertanyaan_anamnesa.getdata') !!}';
            var column = [
                        { data: 'no', name: 'no' },
                        { data: 'pertanyaan_isi', name: 'pertanyaan_isi' },
                        { data: 'pertanyaan_tipe_id', name: 'pertanyaan_tipe_id' },
                        { data: 'pertanyaan_kategori_id', name: 'pertanyaan_kategori_id' },
                        { data: 'status', name: 'status' },
                        { data: 'aksi', name: 'aksi' },
                    ];
           global.init_datatable(id_datatable, url_ajax, column);
        });
    </script>
@endpush