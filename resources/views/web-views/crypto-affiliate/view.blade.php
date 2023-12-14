@extends('layouts.front-end.app')

@section('title','Buy Crypto Currencies')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Brands of {{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Brands of {{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <style>
        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}    !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

        .crypto-card{
            border-radius: 10px;
            border-width: 3px !important;
            border-color: #B38A11 !important;
        }
        .crypto-card img {
            border: 3px solid transparent !important;
            border-radius: 10px;
        }
        .crypto-card:hover img {
            transform: scale(1.15);
            transition: 1s ease-in-out;
            border: 3px solid green !important;
            border-radius: 10px;
        }
        .crypto-card:hover{
            border-color: #B38A11 !important;
        }

    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container mb-md-4">
        <div class="row mt-3 mb-3 border-bottom">
            <div class="col-md-12">
                <h4 class="mt-2">Crypto Currency</h4>
            </div>
        </div>
        <!-- Products grid-->
        <div class="row ">
            <div class="col-lg-12">
                <div class="row">
                    @foreach($crypto_affiliates as $crypto_affiliate)
                    <a href="{{route('crypto-affiliates.show',[$crypto_affiliate['id']])}}">
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-3" data-aos="fade-up">
                            <div class="border crypto-card p-2">
                                <img src="{{$crypto_affiliate->image}}" alt="blog_image" style="width: 100%; height: 195px;" class="img-fluid">
                                <div class="mt-3">
                                    <h5 style="overflow:hidden; height:47px;"><a href="#" class="text-decoration-none text-dark mt-4"> <b>{{$crypto_affiliate->title}}</b></a></h5>
                                    <div style="overflow:hidden; height:67px;"> {!! \Illuminate\Support\Str::limit($crypto_affiliate->description, 120, $end='...') !!}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- sidebar -->
            {{-- <div class="col-lg-3 d-lg-block d-none">
                <div class="row">
                    <div class="review  shadow  bg-body rounded px-3">
                        <h6 class="mb-3 mt-1 text-warning text-bold">Popular Blogs</h6>
                        @foreach($sidebar_blogs as $crypto_affiliate)
                        <a href="{{route('blog.single',[$crypto_affiliate['id']])}}">
                            <div class="person d-flex align-items-center mb-4">
                                <img src="{{$crypto_affiliate->image}}" alt="blog_image"
                                    style="width: 65px; height: 65px;">

                                <div class="mt-1 pl-3">
                                    <p class="lh-base mb-1">{{$crypto_affiliate->title}}</p>
                                    <span class="fw-bold" >{{ $crypto_affiliate->created_at->format('d-m-Y') }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div> --}}
            <!-- end sidebar -->
        </div>

        <div class="row ">
            <div class="col-md-12">
                {{ $crypto_affiliates->links() }}
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
