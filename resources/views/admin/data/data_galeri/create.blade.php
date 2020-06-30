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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add Data Data Galeri</h6>
                                <h2 class="mb-0">Data Galeri</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="Kegiatan">Kegiatan</label>
                                <select name="kegiatan_id" id="Kegiatan" class="form-control">
                                    <option value="">--- Select Data Kegiatan ---</option>
                                    @foreach ($kegiatan as $key => $value)
                                        <option value="{{ $value->kegiatan_id }}">{{ $value->kegiatan_title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- This is For Input News Image --}}

                            {{-- <div class="form-group"> --}}
                                {{-- <label for="Image">News Image</label> --}}
                                <input type="hidden" name="galeri_location" id="Image" value="Dummy!">
                            {{-- </div> --}}

                            {{-- This is End From Input News Image --}}

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