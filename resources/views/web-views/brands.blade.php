@extends('layouts.front-end.app')

@section('title',\App\CPU\translate('All Brands Page'))

@push('css_or_js')
<meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}" />
<meta property="og:title" content="Brands of {{$web_config['name']->value}} " />
<meta property="og:url" content="{{env('APP_URL')}}">
<meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

<meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}" />
<meta property="twitter:title" content="Brands of {{$web_config['name']->value}}" />
<meta property="twitter:url" content="{{env('APP_URL')}}">
<meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
<style>
    .brand_div {
        background: #fcfcfc no-repeat padding-box;
        border: 1px solid #e2f0ff;
        border-radius: 3px;
        opacity: 1;
        padding: 5px;
    }
</style>
@endpush

@section('content')

<!--Page Content-->
<div class="container mb-md-4">
    <div class="row mt-3 mb-3 border-bottom">
        <div class="col-md-8">
            <h4 class="mt-2">{{ \App\CPU\translate('Brands') }}</h4>
        </div>
        <div class="col-md-4">
            <form>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="{{\App\CPU\translate('Brand name')}}" name="brand_name" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">{{\App\CPU\translate('Search')}}</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <!--Content  -->
            <section class="col-lg-12">
                <!--Products grid-->
                <div class="row mx-n2">
                    @foreach($brands as $brand)
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 px-2 pb-4 text-center">
                        <a href="{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}" class="">
                            <div class="brand_div d-flex align-items-center justify-content-center" style="height: 200px">
                                <img onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" src="{{asset("storage/app/public/brand/$brand->image")}}" alt="{{$brand->name}}">
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <hr class="my-3">
                <div class="row mx-n2">
                    <div class="col-md-12">
                        <center>
                            {!! $brands->links() !!}
                        </center>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @endsection

    @push('script')
    <script src="{{asset('public/assets/front-end')}}/vendor/nouislider/distribute/nouislider.min.js"></script>
    @endpush