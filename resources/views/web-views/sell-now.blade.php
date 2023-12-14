@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('Sell Now page'))

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
</style>
  
@endpush

@section('content')
    <!-- Page Content-->
    <div class="product-single-hover" style="">
        <div class="container">
            <div class="col-md-12 mt-5"></div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-3 mt-4"> 
                        <a class="card" href="{{ route('product-details', ['category_id' => $category->id]) }}">
                            <img class="card-img-top" style="height: 250px; width: 100%" src="{{ asset('public/storage/' . $category->image) }}" alt="{{ $category->name }}">
                            <div class="card-body text-center">
                                <h4 class="card-text">{{ $category->name }}</h4>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- <h2>Categories</h2>
 @foreach($categories as $category)
    <div>
        <h3>{{ $category->name }}</h3>
        <img src="{{ asset('public/storage/' . $category->image) }}" alt="{{ $category->name }}">

        <h4>Subcategories</h4>
        @foreach($category->subcategories as $subcategory)
            <p>{{ $subcategory->name }}</p>
        @endforeach
    </div>
@endforeach --}}
   
@endsection


