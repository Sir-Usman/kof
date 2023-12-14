@extends('layouts.front-end.app')

@section('title', $crypto_affiliate->title .' | Crypto Currency')

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

        .person:hover{
            color: #B38A11 !important;
        }
        .person{
            transition: 0.2s ease-in;
        }
        .person span{
            font-size:13px;
            font-weight:bold;
        }
        

        .btnF {
            cursor: pointer;
        }

        .list-link:hover {
            color: #030303 !important;
        }
        .seller_div {
            background: #fcfcfc no-repeat padding-box;
            border: 1px solid #e2f0ff;
            border-radius: 5px;
            opacity: 1;
            padding: 5px;
        }

        @media only screen and (max-width: 730px) {
        .single_blog img {
            height:195px !important;
            }
        }

    </style>
@endpush

@section('content')

    <!-- Page Content-->
    <div class="container mb-md-4">
        <div class="row mt-3 mb-3 border-bottom">
            <div class="col-md-12">
                <h4 class="mt-2">{{$crypto_affiliate->title}}</h4>
            </div>
        </div>
        <div class="row">
            <!-- Content  -->
            <section class="col-lg-12">
                <!-- Products grid-->
                <div class="row mx-n2" style="min-height: 200px">
                    <div class="col-lg-8 mb-3" data-aos="fade-up">

                        <div class="row">
                            <div class="col-lg-5 col-md-4 col-12 rounded">
                                <img src="{{$crypto_affiliate->image}}" style="width: 100%; height: 300px;">
                            </div>
                            <!-- Product details-->
                            <div class="col-lg-7 col-md-8 col-12 mt-md-0 mt-sm-3">
                                <div class="details px-3">
                                    <span class="mb-2" style="font-size: 22px;font-weight:700;">{{$crypto_affiliate->title}}</span>
                                    
                                    <div class="mt-2">{!! \Illuminate\Support\Str::limit($crypto_affiliate->description, 200, $end='...') !!}</div>
    
                                    <div class="mt-5">
                                        <a href="{{$crypto_affiliate->affiliate_link}}" target="_blank" class="btn element-center btn-gap-right" style="background: #FFA825 !important; color: #ffffff;">
                                            <span class="string-limit">Buy now</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- sidebar -->
                    <div class="col-lg-4 d-lg-block d-none">
                        <div class="row g-4 text-start">
                            <h6 class="my-3 text-warning text-bold">Crypto Currencies</h6>
                            @foreach($crypto_affiliates as $crypto_affiliate)
                                <div class="col-12 review shadow bg-body rounded px-3">
                                    <a href="{{route('crypto-affiliates.show',[$crypto_affiliate['id']])}}">
                                        <div class="person d-flex align-items-center mb-4">
                                            <img src="{{$crypto_affiliate->image}}" alt=""
                                            style="width: 65px; height: 65px;">

                                            <div class="mt-1 pl-3">
                                                <p class="lh-base mb-1">{{$crypto_affiliate->title}}</p>
                                                <span class="fw-bold" >{{ $crypto_affiliate->created_at->format('d-m-Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- end sidebar -->
                </div>
            </section>
        </div>
    </div>
@endsection

@push('script')

@endpush
