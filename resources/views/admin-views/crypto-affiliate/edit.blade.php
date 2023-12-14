@extends('layouts.back-end.app')

@section('title', \App\CPU\translate('Crypto Affiliate'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-1 text-capitalize d-flex align-items-center gap-2">
                <img width="20" src="{{asset('/public/assets/back-end/img/banner.png')}}" alt="">
                Crypto Affiliate Update Form
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Content Row -->
        <div class="row" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('admin.crypto-affiliate.update',[$crypto_affiliate['id']])}}" method="post" enctype="multipart/form-data"
                              class="banner_form">
                            @csrf
                            @method('put')
                            <div class="row align-items-center">
                                <div class="col-md-6 mb-5 mb-lg-0">
                                    <div class="form-group">
                                        <input type="hidden" id="id" name="id">
                                        <label for="title" class="title-color text-capitalize">Name</label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title', $crypto_affiliate['title']) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <input type="hidden" id="id" name="id">
                                        <label for="title" class="title-color text-capitalize">Affiliate Link</label>
                                        <input type="text" name="affiliate_link" class="form-control" value="{{ old('affiliate_link', $crypto_affiliate['affiliate_link']) }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="title-color text-capitalize">Detail</label>
                                        <textarea name="description" class="form-control" required id="editor">{{ old('description', $crypto_affiliate['description']) }}"</textarea>
                                    </div>



                                    <label for="image">Image</label>
                                    <div class="custom-file text-left">
                                        <input type="file" name="image" id="image"
                                                class="custom-file-input"
                                                accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label"
                                                for="">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <img
                                            class="upload-img-view"
                                            id="mbImageviewer"
                                            src="{{$crypto_affiliate['image']}}"
                                            alt="Blog_image"/>
                                    </center>
                                </div>

                                <div class="col-md-12 mt-3 d-flex justify-content-end gap-3">
                                    <button type="submit" class="btn btn--primary px-4">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        ClassicEditor
        .create( document.querySelector( '#editor' ) )
            .then( editor => {
                console.log(editor);
            })
        .catch( error => {
            console.error( error );
        } );
    </script>
@endpush
