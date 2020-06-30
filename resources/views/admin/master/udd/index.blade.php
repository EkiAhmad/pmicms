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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Master Data - UDD</h6>
                                <h2 class="mb-0">UDD PMI</h2>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route($route.'create') }}" class="btn btn-sm btn-success">Tambah</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th width="5%" scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Code UDD</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($data as $key => $value)
                                        <tr>
                                            <td scope="row">
                                                {{ $key + 1 }}
                                            </td>
                                            <td>
                                                {{ $value->name }}
                                            </td>
                                            <td>
                                                {{ $value->kode_udd }}
                                            </td>
                                            <td>
                                                <form action="{{ route($route.'delete_action', ['udd_id' => Hashids::encode($value->id)]) }}" method="GET" enctype="multipart/form-data" class="form-global-handle">
                                                    <a href="{{ route($route.'update', ['udd_id' => Hashids::encode($value->id)]) }}" class="btn btn-outline-warning">Edit</a>
                                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
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
@endpush