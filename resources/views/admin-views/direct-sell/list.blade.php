@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Sell-Buy'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

<style>
    .new-entry {
        background-color: #ffecb3; /* Set your desired background color for new entries */
    }
</style>

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div>
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h2 class="h1 mb-0">
                    <img src="{{asset('/public/assets/back-end/img/all-orders.png')}}" class="mb-1 mr-1" alt="">
                    {{\App\CPU\translate('Product')}}
                </h2>
                <span class="badge badge-soft-dark radius-50 fz-14">List</span>
            </div>

            <!-- Product detail -->
             <div class="card">    
                <div class="card-body"> 
                    <!-- Data Table Top -->
                    <div class="px-3 py-4 light-bg">
                        <div class="row g-2 flex-grow-1">
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="" method="GET">
                                    <!-- Search -->
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="search-input" type="search" name="search" class="form-control"
                                            placeholder="{{\App\CPU\translate('Search')}}" aria-label="Search by Order ID" value=""
                                            required>
                                        <button type="submit" class="btn btn--primary input-group-text">{{\App\CPU\translate('search')}}</button>
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                            <div class="col-sm-4 col-md-6 col-lg-8 d-flex justify-content-sm-end">
                                <a href="{{ url('admin/direct-sell/category') }}"><button type="button" class="btn btn-outline-primary mr-2">
                                    Add Category
                                </button></a>
                                <a href="{{ url('admin/direct-sell/showcate') }}"><button type="button" class="btn btn-outline-info">
                                    Update Category
                                </button></a>  
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Condition</th>
                                    <th>Phone No</th>
                                    <th>Button</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                @php
                                                                $viewedProducts = json_decode(request()->cookie('viewedProducts'), true) ?? [];
                                                            @endphp
                                    <tr id="product-{{ $product->id }}" class="{{ in_array($product->id, $viewedProducts) ? '' : 'new-entry' }}">
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->button }}</td>
                                        <td>{{ $product->contact }}</td>
                                        <td>
                                            <a href="{{ route('admin.direct-sell.edit', $product) }}" class="btn btn-outline-success view-btn" data-product-id="{{ $product->id }}">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                    <!-- Pagination -->
                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            <!-- Pagination -->
                            {{ $products->links() }}
                        </div>
                    </div>
                    <!-- End Pagination -->
                </div>
            </div> 
            <!-- End Order States -->

            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal d-none">
                <span class="hs-nav-scroller-arrow-prev d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-left"></i>
                    </a>
                </span>

                <span class="hs-nav-scroller-arrow-next d-none">
                    <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                        <i class="tio-chevron-right"></i>
                    </a>
                </span>

                <!-- Nav -->
                <ul class="nav nav-tabs page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">{{\App\CPU\translate('order_list')}}</a>
                    </li>
                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->
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
    </script>

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
        $("#search-input").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Retrieve the viewed products from the cookie
            var viewedProducts = JSON.parse(getCookie('viewedProducts')) || [];

            document.querySelectorAll('.view-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    var productId = this.getAttribute('data-product-id');

                    if (!viewedProducts.includes(productId)) {
                        viewedProducts.push(productId);
                        setCookie('viewedProducts', JSON.stringify(viewedProducts), 365); // Set cookie to expire in 365 days
                        // Remove the 'new-entry' class from the clicked row
                        document.getElementById('product-' + productId).classList.remove('new-entry');
                    }
                });
            });

            // Remove the 'new-entry' class for all previously viewed products
            document.querySelectorAll('.new-entry').forEach(function(row) {
                var productId = row.getAttribute('id').replace('product-', '');
                if (viewedProducts.includes(productId)) {
                    row.classList.remove('new-entry');
                }
            });
        });

        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
    </script>
@endpush



