@extends('layouts.back-end.app')
@section('title', \App\CPU\translate('Sell-Buy'))

@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush



@section('content')

    <div class="content container-fluid">
        <!-- Page Header -->
        <div>
            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                <h2 class="h1 mb-0">
                    <img src="{{asset('/public/assets/back-end/img/all-orders.png')}}" class="mb-1 mr-1" alt="">
                    {{\App\CPU\translate('Category')}}
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
                        </div>
                        <!-- End Row -->
                    </div>

                    <!-- Table -->
                    <div class="table-responsive datatable-custom">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                    <th>Function</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>
                                            <img src="{{ asset('public/storage/' . $category->image) }}" alt="{{ $category->name }}" style="height: 50px; width: 50px;">
                                        </td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href=" {{ url('admin/direct-sell/editcate', $category) }} " class="btn btn-primary">Update</a>
                                        </td>

                                        <td>
                                            <form action="{{ url('admin/direct-sell/deletecate', $category->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
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
                            {{ $categories->links() }}
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
@endpush



