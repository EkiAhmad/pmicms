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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add Data Kegiatan</h6>
                                <h2 class="mb-0">Kegiatan</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="Title">Title</label>
                                <input type="text" name="kegiatan_title" class="form-control" id="Title" placeholder="Masukkan Kegiatan Title Disini ...">
                            </div>

                            <div class="form-group">
                                <label for="Waktu_Mulai">Waktu Mulai</label>
                                <input type="date" name="tgl_mulai" class="form-control" id="Waktu_Mulai" placeholder="Masukkan Waktu Mulai Disini ...">
                            </div>

                            <div class="form-group">
                                <label for="Waktu_Akhir">Waktu Akhir</label>
                                <input type="date" name="tgl_selesai" class="form-control" id="Waktu_Akhir" placeholder="Masukkan Waktu Akhir Disini ...">
                            </div>

                            <div class="form-group">
                                <label for="Content">Content</label>
                                <textarea name="kegiatan_content" id="Content" cols="30" rows="10" class="form-control" placeholder="Masukkan Kegiatan Content Disini ..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Type">Type</label>
                                <select name="kegiatan_type" id="Type" class="form-control">
                                    <option value="">--- Select Kegiatan Type ---</option>
                                    <option value="P">Tertutup</option>
                                    <option value="U">Umum</option>
                                </select>
                            </div>

                            {{-- Start Titik Lokasi --}}
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="Titik_Lokasi">Titik Lokasi</label> --}}
                                <input type="hidden" name="lat" class="form-control" id="Titik_Lokasi" value="0">
                                <input type="hidden" name="lng" class="form-control" id="Titik_Lokasi" value="0">
                            {{-- </div> --}}
                            {{-- End Titik Lokasi --}}

                            <div class="form-group">
                                <label for="Lokasi">Lokasi</label>
                                <input type="text" name="lokasi" class="form-control" id="Lokasi" placeholder="Masukkan Lokasi Disini ...">
                            </div>

                            {{-- Start Kegiatan Image --}}
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="Image">Image</label> --}}
                                <input type="hidden" name="kegiatan_image" class="form-control" id="Image" value="Dummy.png">
                            {{-- </div> --}}
                            {{-- End Kegiatan Image --}}

                            {{-- Start Kegiatan Estimasi --}}
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="Estimasi">Estimasi</label> --}}
                                <input type="hidden" name="kegiatan_estimasi" class="form-control" id="Estimasi" value="0">
                            {{-- </div> --}}
                            {{-- End Kegiatan Estimasi --}}

                            {{-- Start Kegiatan Status --}}
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="Status">Status</label> --}}
                                <input type="hidden" name="kegiatan_status" class="form-control" id="Status" value="Y">
                            {{-- </div> --}}
                            {{-- End Kegiatan Status --}}

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