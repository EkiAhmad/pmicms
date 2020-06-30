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
                                <h6 class="text-uppercase text-muted ls-1 mb-1">Add Data News</h6>
                                <h2 class="mb-0">News</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'create_action') }}" class="form-global-handle" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="Title">News Title</label>
                                <input type="text" name="news_title" class="form-control" id="Title" placeholder="Input News Title Here ...">
                            </div>
                            <div class="form-group">
                                <label for="Content">News Content</label>
                                <textarea class="form-control" name="news_content" id="Content" cols="30" rows="10" placeholder="Input News Content Here ..."></textarea>
                            </div>

                            <div class="form-group">
                                <label for="Author">News Author</label>
                                <select name="news_author_id" id="Author" class="form-control">
                                    <option value="">--- Select News Author ---</option>
                                    @foreach ($author as $key => $value)
                                        <option value="{{ $value->user_id }}">{{ $value->user_username }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Type">News Type</label>
                                <select name="news_type" id="Type" class="form-control">
                                    <option value="">--- Select News Type ---</option>
                                    <option value="A">Berita</option>
                                    <option value="B">Edukasi</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Category">News Category</label>
                                <select name="news_category_id" id="Category" class="form-control">
                                    <option value="">--- Select News Category ---</option>
                                    @foreach ($category as $key => $value)
                                        <option value="{{ $value->category_id }}">{{ $value->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Start News Image --}}
                            {{-- <div class="form-group"> --}}
                                {{-- <label for="Image">News Image</label> --}}
                                <input type="hidden" name="news_image" id="Image" class="form-control" value="Dummy.png">
                            {{-- </div> --}}
                            {{-- End News Image --}}

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