@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('product-details page'))

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Categories of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Categories of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    
<style>
    .quick-view{
        display: none;
        padding-bottom: 8px;
    }

    .quick-view , .single-product-details{
        background: #ffffff;
    }
    .product-single-hover:hover > .single-product-details {

        margin-top:-39px;
    }
    .product-single-hover:hover >  .quick-view{
        display: block;
    }

    .card:hover{
     transform: scale(1.05);
     box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
    }

    .btn:hover{
     transform: scale(1.05);
     box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
    }

    .preview-image {
        max-width: 100px;  /* Adjust the maximum width as needed */
        max-height: 100px; /* Adjust the maximum height as needed */
        margin: 10px;      /* Add spacing between images if desired */
    }
</style>
  
@endpush

@section('content')
    <!-- Page Content-->

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
     <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="product-info">
                <div class="product-left">
                    <div class="product-image direction-vertical position-left">
                        <div class="swiper main-image" data-option = "{&quot;speed&quot;:500,&quot;autoplay&quot;:false,&quot;pauseOnHover&quot;:true,&quot;loop&quot;:false}">
                            <div class="swiper-container swiper-container-initialized swiper-container-horizontal">
                                <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                                    <div class="swiper-slide swiper-slide-visible swiper-slide-active" style="width: 346px">
                                        <div class="card" style="margin-top: 75px; margin-left: 40px">
                                        <div class="card-body mt-2">
                                            <p class="card-text">For individual items it is necessary that you send us a price request because the current daily price cannot be determined daily. You will receive the answer in a few minutes by call.</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>                    
                            </div>             
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="col-md-8">
                   <div class="product-right">
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <h3>PRICE INQUIRY IN FEW MINUTES</h3>
                            
                            <div class="card mt-3">
                                <h4 class="card-header">{{ __('Item Condition') }}</h4>

                                <div class="card-body">
                                    <form method="POST" action="{{ route('product-details.store') }}" id="product-form" enctype="multipart/form-data">
                                        @csrf
                                        <h4>Please Choose</h4>

                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btn btn-primary">
                                                <input type="radio" name="button" value="New"> New
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="button" value="Like New"> Like New
                                            </label>
                                            <label class="btn btn-primary">
                                                <input type="radio" name="button" value="Old">Old 
                                            </label>
                                            <!-- Add more radio buttons for other conditions -->
                                        </div>
                                                          
                                        <br><br>
                                        <div class="form-group row">
                                            <div class="col-md-8">
                                             <label for="text">Product Identification</label>
                                                <input id="text" type="text" class="form-control" name="product_identification" value="" required autocomplete="product_identification" autofocus>

                                                @error('product_identification')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-8">
                                                <label for="text">Subcategory</label><br>
                                                <div class="input-group">
                                                    <select name="sub_categories[]" id="sub_categories" class="form-control">
                                                        <option value="">Select Subcategory</option>
                                                        @foreach($subcategories as $subcategory)
                                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- <h2>Subcategories</h2>
                                                <ul>
                                                    @foreach($subcategories as $subcategory)
                                                        <li>{{ $subcategory->name }}</li>
                                                    @endforeach
                                                </ul> --}}
                                            
                                            <div class="col-md-8">
                                             <label for="text">TECHNICAL DATA</label>
                                                <input id="text" type="text" class="form-control" name="technical_data" value="" required autocomplete="product_identification" autofocus>

                                                @error('technical_data')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-8">
                                             <label for="text">YOUR DESIRED PRICE</label>
                                                <input id="text" type="text" class="form-control" name="your_desired_price" value="" required autocomplete="product_identification" autofocus>

                                                @error('your_desired_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-md-8">
                                             <label for="text">Phone No</label>
                                                <input id="text" type="text" class="form-control" name="contact" value="" required autocomplete="contact" autofocus>
                                                @error('contact')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="images">{{ __('Product Images') }}</label>
                                                <input type="file" name="images[]" id="images" class="form-control-file" multiple>
                                            </div>
                                        </div>

                                        <!-- Add more form fields as needed -->
                                         <button type="submit" id="submit-button" class="btn btn-success" style="background-color: #b38a11; color:black">
                                                    {{ __('Submit') }}
                                         </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
   
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
    $('#submit-button').click(function () {
        var formData = new FormData($('#product-form')[0]);

        $.ajax({
            url: "{{ route('product-details.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                // Handle success (e.g., show a success message or redirect)
                console.log(response);
            },
            error: function (xhr) {
                // Handle errors (e.g., display validation errors)
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    // Loop through errors and display them
                    console.log(errors);
                }
            },
        });
    });
});
</script>

{{-- <script>
    $(document).ready(function () {
        // Intercept the click event on category links
        $('.category-link').click(function (e) {
            e.preventDefault();

            // Extract the category ID from the clicked link's href
            var url = $(this).attr('href');
            var category_id = url.split('=')[1];

            // Use AJAX to fetch subcategories based on the selected category
            $.ajax({
                url: '/get-subcategories/' + category_id, // Update the URL according to your route
                type: 'GET',
                success: function (data) {
                    // Clear existing options
                    $('#subcategorySelect').empty();

                    // Append new options based on the AJAX response
                    $.each(data, function (index, subcategory) {
                        $('#subcategorySelect').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                    });
                },
                error: function (error) {
                    console.error('Error fetching subcategories:', error);
                }
            });
        });
    });
</script> --}}
@endsection