@extends('layouts.back-end.app')

@section('title',$seller->shop ? $seller->shop->name : \App\CPU\translate("shop name not found"))

@push('css_or_js')

@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/coupon_setup.png')}}" alt="">
                {{\App\CPU\translate('Seller_Details')}}
            </h2>
        </div>
        <!-- End Page Title -->

        <!-- Page Heading -->
        <div class="flex-between d-sm-flex row align-items-center justify-content-between mb-2 mx-1">
            <div>
                <a href="{{route('admin.sellers.seller-list')}}"
                   class="btn btn--primary mt-3 mb-3">{{\App\CPU\translate('Back_to_seller_list')}}</a>
            </div>
            <div>
                @if ($seller->status=="pending")
                    <div class="mt-4 pr-2 float-{{Session::get('direction') === "rtl" ? 'left' : 'right'}}">
                        <div class="flex-start">
                            <div class="mx-1"><h4><i class="tio-shop-outlined"></i></h4></div>
                            <div>{{\App\CPU\translate('Seller_request_for_open_a_shop.')}}</div>
                        </div>
                        <div class="text-center">
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                        class="btn btn--primary btn-sm">{{\App\CPU\translate('Approve')}}</button>
                            </form>
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit"
                                        class="btn btn-danger btn-sm">{{\App\CPU\translate('reject')}}</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <form>
            
            <div class="row">
                <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('First Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="name" value="{{$seller->f_name}}"  required>
                            </div>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Last Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="name" value="{{$seller->l_name}}"  required>
                            </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Email')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="email" value="{{$seller->email}}"  required>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Phone')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="phone" value="{{$seller->phone}}"  required>
                            </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('CNIC Photo')}}</label>
                                <input type="file" class="form-control form-control-user" id="exampleFirstName" name="photo" value="{{old('photo')}}" placeholder="{{\App\CPU\translate('Ex: Jhone')}}">
                            </div>
                </div>
            </div>
            <hr>
            <h5>Bank Details</h5>
            
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Bank Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="bankName" value="{{$seller->bank_name}}">
                            </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Branch')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="branch" value="{{$seller->branch}}">
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Account Holder Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="accountHolderName" value="{{$seller->holder_name}}">
                            </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Account No')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="accountNo" value="{{$seller->account_no}}" placeholder="{{\App\CPU\translate('Ex: Jhone')}}">
                            </div>
                </div>
            </div>
            
            <hr>
            <h5>Shop Info</h5>
            
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Shop Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="shopName" value="{{$seller->shop->name}}">
                            </div>
                </div>
                <div class="col-lg-6 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Contact No')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="sellerContact" value="{{$seller->shop->contact}}">
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Address')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="sellerAddress" value="{{$seller->shop->address}}">
                            </div>
                </div>
                
            </div>
            
            
        </form>
        
    </div>
@endsection

@push('script')

@endpush
