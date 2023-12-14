@extends('layouts.front-end.app')

@section('title','Blogs')

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
        .blog_main p{
            color:gray;
        }
        .blog_main p:hover{
            color: #B38A11 !important;
        }
        
        
        .blog-card{
            overflow: hidden;
        }
        .blog-card img{
        }
        .blog-card:hover img {
            transform: scale(1.1);
            transition: 1s ease-in-out;
            border-radius: 10px;

        }

       

    </style>
@endpush

@section('content')
     <!--Page Content-->
    <div class="container mb-md-4">
        <div class="row mt-3 mb-3 border-bottom">
            <div class="col-md-8">
                <h4 class="mt-2">Blogs</h4>
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
        
         <!--Products grid-->
        <div class="row">
            <div class="col-lg-9">
                <div class="row blog_main">
                    @foreach($blogs as $blog)
                    <a href="{{route('blog.single',[$blog['id']])}}">
                        <div class="col-lg-4 mb-3 blog-card">
                            <img src="{{$blog->image}}" alt="blog_image" style="width: 100%; height: 195px;" class="img-fluid">
                            <div class="mt-3">
                                <small>Posted in 
                                    <span class="fw-bold text-dark px-1">
                                        {{ $blog->created_at->format('d-m-Y') }}
                                    </span> 
                                </small>
                                <h5><a href="#" class="text-decoration-none text-dark mt-4"> <b>{{$blog->title}}</b></a></h5>
                                <p>
                                {{-- {!! \Illuminate\Support\Str::limit($blog->description, 120, $end='...') !!} --}}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            
            

             <!--sidebar -->
            <div class="col-lg-3 d-lg-block d-none">
                <div class="row">
                    <div class="review  bg-body rounded px-3">
                        <h6 class="mb-3 mt-1 text-warning text-bold">Popular Blogs</h6>
                        @foreach($sidebar_blogs as $blog)
                        <a href="{{ route('blog.single', [$blog['id']]) }}">
                            <div class="person shadow d-flex align-items-center mb-4">
                                <img src="{{$blog->image}}" alt="blog_image" style="width: 65px; height: 65px;">

                                <div class="mt-1 pl-3">
                                    <p class="lh-base mb-1">{{ $blog->title }}</p>
                                    <span class="fw-bold" >{{ $blog->created_at->format('d-m-Y') }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
             <!--end sidebar -->
        </div>

        <div class="row ">
            <div class="col-md-12">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
@endsection

@push('script')

@endpush
