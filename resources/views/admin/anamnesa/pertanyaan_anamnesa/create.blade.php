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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add Anamnesa Question</h6>
                                <h2 class="mb-0">Anamnesa Question</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="PertanyaanIsi">Isi Pertanyaan</label>
                                <input type="text" name="pertanyaan_isi" class="form-control" id="PertanyaanIsi">
                            </div>
                            <div class="form-group">
                                <label for="PertanyaanTipe">Tipe Pertanyaan</label>
                                {{-- <input type="text" name="pertanyaan_tipe_id" class="form-control" id="PertanyaanTipe"> --}}
                                {{-- {{dd($tipe)}} --}}
                                <select class="custom-select" name="pertanyaan_tipe_id" id="PertanyaanTipe">
                                    <option selected disabled>Tipe Pertanyaan</option>
                                        @foreach ($tipe as $key => $value)
                                            <option value="{{ $value->tipe_id }}">{{$value->tipe_name}}</option>
                                        @endforeach
                                </select>
                                {{-- <small>
                                    <div>
                                        <i class="ni ni-air-baloon"></i>
                                        <span>Min / Max 4 Char</span>
                                    </div>
                                </small> --}}
                            </div>
                            <div class="form-group">
                                <label for="PertanyaanKategori">Kategori Pertanyaan</label>
                                <select class="custom-select" name="pertanyaan_kategori_id" id="PertanyaanKategori">
                                    <option selected>Kategori Pertanyaan</option>
                                        @foreach ($kategori as $key => $value)
                                            <option value="{{ $value->kategori_id }}">{{$value->kategori_judul}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="PertanyaanStatus">Status Pertanyaan</label>
                                <select class="custom-select" name="status" id="PertanyaanStatus">
                                    <option selected>Status Pertanyaan</option>
                                    <option value="0">Tidak Tampil</option>
                                    <option value="1">Tampil</option>
                                </select>
                            </div>
                            <div class="group">
                                <button type="submit" class="btn btn-outline-success">Save</button>
                                <a class="btn btn-outline-info" href="{{ route($route.'index') }}">Back</a>
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