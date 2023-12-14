@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Direct Sell'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->

    <div class="mb-3">
        <h2 class="h1 mb-0 d-flex gap-10">
            <img src="{{asset('/public/assets/back-end/img/brand-setup.png')}}" alt="">
            {{\App\CPU\translate('Direct-Sell')}} {{\App\CPU\translate('Category')}}
        </h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                <form action="{{ isset($category) ? route('admin.direct-sell.updatecate', ['id' => $category->id]) : route('admin.direct-sell.storecate') }}" method="post" id="categoryForm" name="categoryForm" enctype="multipart/form-data">
                    @csrf
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">                                
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', isset($category) ? $category->name : '') }}" placeholder="Name">
                                        @if ($errors->has('name'))
                                            <div class="alert alert-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="from_part_2">
                                    <label class="title-color">{{\App\CPU\translate('Category_Logo')}}</label>
                                    <span class="text-info"><span class="text-danger">*</span> ( {{\App\CPU\translate('ratio')}} 1:1 )</span>
                                    <div class="custom-file text-left">
                                        <input type="file" name="image" id="customFileEg1" class="custom-file-input" accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileEg1">{{\App\CPU\translate('choose')}} {{\App\CPU\translate('file')}}</label>
                                    </div>

                                    @if ($errors->has('image'))
                                        <div class="alert alert-danger">
                                            {{ $errors->first('image') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                                    <div class="form-group ml-10">
                                        <center>
                                            <img class="upload-img-view" id="viewer" src="{{ asset(old('image', isset($category) ? 'public/storage/' . $category->image : 'public/assets/back-end/img/900x400/img1.jpg')) }}" alt="image"/>
                                        </center>
                                    </div>
                                </div>

                                <!-- Subcategories Section -->
                                <div class="col-md-12">
                                    <div id="subcategories-container">
                                        @if(isset($category) && $category->subcategories->isNotEmpty())
                                            @foreach($category->subcategories as $index => $subcategory)
                                                <div class="subcategories-section mb-3">
                                                    <label for="subcategories">Subcategory</label>
                                                    <input type="text" name="subcategories[]" class="form-control" placeholder="Subcategory" value="{{ old('subcategories.' . $index, $subcategory->name) }}">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="subcategories-section mb-3">
                                                <label for="subcategories">Subcategories</label>
                                                <input type="text" name="subcategories[]" class="form-control" placeholder="Subcategory">
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-primary" id="addSubcategory">Add Subcategory</button>
                                </div>
                            </div>
                        </div>                            
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="{{ route('admin.direct-sell.showcate') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        // Add event listener for toggling the carousel
        $(".carousel-toggle").click(function() {
            var targetCarousel = $(this).data("target");
            $(targetCarousel).toggle();
        });

        // Add event listener for the search input
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    </script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);

                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function () {
            readURL(this);
        });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const subcategoriesContainer = document.getElementById("subcategories-container");
        const addSubcategoryButton = document.getElementById("addSubcategory");

        addSubcategoryButton.addEventListener("click", function () {
            const subcategorySection = document.createElement("div");
            subcategorySection.className = "subcategories-section mb-3";
            subcategorySection.innerHTML = `
                <label for="subcategories">Subcategory</label>
                <input type="text" name="subcategories[]" class="form-control" placeholder="Subcategory">
            `;
            subcategoriesContainer.appendChild(subcategorySection);
        });
    });
</script>
@endpush