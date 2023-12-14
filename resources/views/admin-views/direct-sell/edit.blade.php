@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Sell-Buy'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <!-- Page Heading -->

    <div class="container mt-10">
        <div class="row">
            <div class="col-md-12">
                {{-- start Table --}}
                <div class="container">
                    <h1>Product Details</h1>
                    <form method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Condition Field -->
                        <div class="form-group">
                            <label for="condition">Condition</label>
                            <input type="text" readonly name="button" id="button" class="form-control" value="{{ old('button', $product->button) }}" required>
                        </div>

                        {{-- Subcategory --}}
                        <div class="form-group">
                            <label for="condition">subcategories</label>
                            <input type="text" readonly name="subcategories" id="subcategories" class="form-control" value="{{ old('subcategories', $product->sub_categories) }}" required>
                        </div>

                        <!-- Product Identification Field -->
                        <div class="form-group">
                            <label for="product_identification">Product Identification</label>
                            <input type="text" readonly name="product_identification" id="product_identification" class="form-control" value="{{ old('product_identification', $product->product_identification) }}" required>
                        </div>

                        <!-- Technical Data Field -->
                        <div class="form-group">
                            <label for="technical_data">Technical Data</label>
                            <textarea name="technical_data" readonly id="technical_data" class="form-control" rows="4" required>{{ old('technical_data', $product->technical_data) }}</textarea>
                        </div>

                        <!-- Your Desired Price Field -->
                        <div class="form-group">
                            <label for="your_desired_price">Your Desired Price</label>
                            <input type="number" readonly name="your_desired_price" id="your_desired_price" class="form-control" value="{{ old('your_desired_price', $product->your_desired_price) }}" required>
                        </div>

                        <!-- Contact Field -->
                        <div class="form-group">
                            <label for="contact">Contact</label>
                            <input type="text" readonly name="contact" id="contact" class="form-control" value="{{ old('contact', $product->contact) }}" required>
                        </div>

                        <!-- Images Field -->
                        <div id="imageCarousel" class="carousel slide" data-ride="carousel" style="width: 50%;">
                            <div class="carousel-inner">
                                @foreach(explode("|", $product->images) as $key => $image)
                                    <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                                        <img src="{{ asset('public/storage/' . $image) }}" class="d-block w-100" alt="Image not found">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        {{-- <button type="submit" class="btn btn-primary">Update</button> --}}
                    </form>
                </div>
                {{-- End Table --}}

                
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
@endpush