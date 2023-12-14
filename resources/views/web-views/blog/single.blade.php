@extends('layouts.front-end.app')

@section('title', $blog->title)

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
            <div class="col-md-8">
                <h4 class="mt-2">{{$blog->title}}</h4>
            </div>
            <div class="col-md-4">
                <form action="{{route('search-shop')}}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control"  placeholder="{{\App\CPU\translate('Shop name')}}" name="shop_name" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">{{\App\CPU\translate('Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <!-- Content  -->
            <section class="col-lg-12">
                <!-- Products grid-->
                <div class="row mx-n2" style="min-height: 200px">
                    <div class="col-lg-8 mb-3" data-aos="fade-up">
                        <div class="col-lg-9 single_blog">
                            <img src="{{$blog->image}}" alt="blog_image"  style="width: 100%; height: 300px;">
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between align-items-center">
                                 title + likes 
                                <div class="d-flex align-items-center justify-content-between pt-2">
                                    <h4 class="text-dark">{{$blog->title}}</h4>
                                    <a href="#"><i class="bx bxs-heart ms-2"></i></a>
                                </div>
                                 created_at date 
                                <div>
                                    <small class="fw-bold">{{ $blog->created_at->format('d-m-Y') }}</small>
                                </div>
                            </div>
                            <p> <span class="ps-4"></span>{!!$blog->description!!}</p>
                        </div>
                    </div>

                    <!-- sidebar -->
                    <div class="col-lg-4 d-lg-block d-none">
                        <div class="row g-4 text-start">
                            <div class="review  shadow  bg-body rounded px-3">
                                <h6 class="my-3 text-warning text-bold">Popular Blogs</h6>
                                @foreach($blogs as $blog)
                                <a href="{{route('blog.single',[$blog['id']])}}">
                                    <div class="person d-flex align-items-center mb-4">
                                        <img src="{{$blog->image}}" alt=""
                                        style="width: 65px; height: 65px;">

                                        <div class="mt-1 pl-3">
                                            <p class="lh-base mb-1">{{$blog->title}}</p>
                                            <span class="fw-bold" >{{ $blog->created_at->format('d-m-Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
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
