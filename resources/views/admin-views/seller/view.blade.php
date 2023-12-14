@extends('layouts.back-end.app')

@section('title', $seller->shop? $seller->shop->name : \App\CPU\translate("Shop Name"))

@push('css_or_js')
    <style>
        .modal-content{
  border:#073B74 6px solid;
}
.overlay{
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 999;
    background: rgba(255,255,255,0.8) url("loader.gif") center no-repeat;
}
/* Turn off scrollbar when body element has the loading class */
body.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
body.loading .overlay{
    display: block;
}
</style>
@endpush

@section('content')
    <div class="content container-fluid">
        <!-- Page Title -->
        <div class="mb-3">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{asset('/public/assets/back-end/img/add-new-seller.png')}}" alt="">
                {{\App\CPU\translate('seller_details')}}
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
                            <h4 class="mx-1"><i class="tio-shop-outlined"></i></h4>
                            <div><h4>{{\App\CPU\translate('Seller_request_for_open_a_shop.')}}</h4></div>
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

        <!-- Page Header -->
        <div class="page-header">
            <div class="flex-between row mx-1">
                <div>
                    <h1 class="page-header-title">{{ $seller->shop? $seller->shop->name : "Shop Name : Update Please" }}</h1>
                </div>
            </div>
            <!-- Nav Scroller -->
            <div class="js-nav-scroller hs-nav-scroller-horizontal">
                <!-- Nav -->
                <ul class="nav nav-tabs flex-wrap page-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active"
                           href="{{ route('admin.sellers.view',$seller->id) }}">{{\App\CPU\translate('Shop')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'order']) }}">{{\App\CPU\translate('Order')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'product']) }}">{{\App\CPU\translate('Product')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'setting']) }}">{{\App\CPU\translate('Setting')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'transaction']) }}">{{\App\CPU\translate('Transaction')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('admin.sellers.view',['id'=>$seller->id, 'tab'=>'review']) }}">{{\App\CPU\translate('Review')}}</a>
                    </li>

                </ul>
                <!-- End Nav -->
            </div>
            <!-- End Nav Scroller -->
        </div>
        <!-- End Page Header -->

        <div class="card mb-3">
            <div class="card-body">

                <div class="row justify-content-between align-items-center g-2 mb-3">
                    <div class="col-sm-6">
                        <h4 class="d-flex align-items-center text-capitalize gap-10 mb-0">
                            <img width="20" class="mb-1" src="{{asset('/public/assets/back-end/img/admin-wallet.png')}}" alt="">
                            {{\App\CPU\translate('Seller_Wallet')}}
                        </h4>
                    </div>
                </div>

                <div class="row g-2" id="order_stats">
                    <div class="col-lg-4">
                        <!-- Card -->
                        <div class="card h-100 d-flex justify-content-center align-items-center">
                            <div class="card-body d-flex flex-column gap-10 align-items-center justify-content-center">
                                <img width="48" class="mb-2" src="{{asset('/public/assets/back-end/img/withdraw.png')}}" alt="">
                                <h3 class="for-card-count mb-0 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->total_earning)) : 0 }}</h3>
                                <div class="font-weight-bold text-capitalize mb-30">
                                    {{\App\CPU\translate('Withdrawable_balance')}}
                                </div>
                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <div class="col-lg-8">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->pending_withdraw)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\translate('Pending_Withdraw')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" class="mb-2" src="{{asset('/public/assets/back-end/img/pw.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->commission_given)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\translate('Total_Commission_given')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/tcg.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{$seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->withdrawn)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\translate('Aready_Withdrawn')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/aw.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->delivery_charge_earned)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\translate('total_delivery_charge_earned')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/tdce.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->total_tax_collected)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\translate('total_tax_given')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/ttg.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-body h-100 justify-content-center">
                                    <div class="d-flex gap-2 justify-content-between align-items-center">
                                        <div class="d-flex flex-column align-items-start">
                                            <h3 class="mb-1 fz-24">{{ $seller->wallet ? \App\CPU\BackEndHelper::set_symbol(\App\CPU\BackEndHelper::usd_to_currency($seller->wallet->collected_cash)) : 0}}</h3>
                                            <div class="text-capitalize mb-0">{{\App\CPU\translate('collected_cash')}}</div>
                                        </div>
                                        <div>
                                            <img width="40" src="{{asset('/public/assets/back-end/img/cc.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-capitalize">
                        <h5 class="mb-0">{{\App\CPU\translate('Seller')}} {{\App\CPU\translate('Account')}}</h5>
                        <button type="button" id="editSeller" onclick="editSeller()"
                                        class="btn btn-sm btn-outline-primary">{{\App\CPU\translate('Edit Seller')}}</button>
                        @if($seller->status=='approved')
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="suspended">
                                <button type="submit"
                                        class="btn btn-sm btn-outline-danger">{{\App\CPU\translate('suspend')}}</button>
                            </form>
                        @elseif($seller->status=='rejected' || $seller->status=='suspended')
                            <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{$seller->id}}">
                                <input type="hidden" name="status" value="approved">
                                <button type="submit"
                                        class="btn btn-outline-success">{{\App\CPU\translate('activate')}}</button>
                            </form>
                        @endif
                    </div>
                    <div class="card-body"
                         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <div class="flex-start">
                            <div><h4>{{\App\CPU\translate('Status')}} : </h4></div>
                            <div class="mx-1">
                                <h4>{!! $seller->status=='approved'?'<label class="badge badge-success">Active</label>':'<label class="badge badge-danger">In-Active</label>' !!}</h4>
                            </div>
                        </div>
                        <div class="flex-start">
                            <div><h5>{{\App\CPU\translate('name')}} : </h5></div>
                            <div class="mx-1"><h5>{{$seller->f_name}} {{$seller->l_name}}</h5></div>
                        </div>
                        <div class="flex-start">
                            <div><h5>{{\App\CPU\translate('Email')}} : </h5></div>
                            <div class="mx-1"><h5>{{$seller->email}}</h5></div>
                        </div>
                        <div class="flex-start">
                            <div><h5>{{\App\CPU\translate('Phone')}} : </h5></div>
                            <div class="mx-1"><h5>{{$seller->phone}}</h5></div>
                        </div>
                        <div class="flex-start">
                            <div><h5>{{\App\CPU\translate('Id Card')}} : </h5></div>
                            <div class="mx-1"><h5>
                              
                               <img width="50"
                                                onerror="this.src='{{asset('public/assets/back-end/img/400x400/img2.jpg')}}'"
                                                src="{{asset('storage/app/public/seller')}}/{{$seller->image}}"
                                                alt=""> 
                               </h5></div>
                        </div>
                    </div>
                </div>
            </div>
            @if($seller->shop)
                <div class="col-md-6 mt-2 mt-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{\App\CPU\translate('Shop')}} {{\App\CPU\translate('info')}}</h5>
                        </div>
                        <div class="card-body"
                             style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                            <div class="flex-start">
                                <div><h5>{{\App\CPU\translate('seller')}} : </h5></div>
                                <div class="mx-1"><h5>{{$seller->shop->name}}</h5></div>
                            </div>
                            <div class="flex-start">
                                <div><h5>{{\App\CPU\translate('Phone')}} : </h5></div>
                                <div class="mx-1"><h5>{{$seller->shop->contact}}</h5></div>
                            </div>
                            <div class="flex-start">
                                <div><h5>{{\App\CPU\translate('address')}} : </h5></div>
                                <div class="mx-1"><h5>{{$seller->shop->address}}</h5></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-md-6 mt-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"> {{\App\CPU\translate('bank_info')}}</h5>
                    </div>
                    <div class="card-body"
                         style="text-align: {{Session::get('direction') === "rtl" ? 'right' : 'left'}};">
                        <div class="mt-2">
                            <div class="flex-start">
                                <div><h4>{{\App\CPU\translate('bank_name')}} : </h4></div>
                                <div class="mx-1">
                                    <h4>{{$seller->bank_name ? $seller->bank_name : \App\CPU\translate('No Data found')}}</h4>
                                </div>
                            </div>
                            <div class="flex-start">
                                <div><h6>{{\App\CPU\translate('Branch')}} : </h6></div>
                                <div class="mx-1">
                                    <h6>{{$seller->branch ? $seller->branch : \App\CPU\translate('No Data found')}}</h6>
                                </div>
                            </div>
                            <div class="flex-start">
                                <div><h6>{{\App\CPU\translate('holder_name')}} : </h6></div>
                                <div class="mx-1">
                                    <h6>{{$seller->holder_name ? $seller->holder_name : \App\CPU\translate('No Data found')}}</h6>
                                </div>
                            </div>
                            <div class="flex-start">
                                <div><h6>{{\App\CPU\translate('account_no')}} : </h6></div>
                                <div class="mx-1">
                                    <h6>{{$seller->account_no ? $seller->account_no : \App\CPU\translate('No Data found')}}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--Edit Modal for Seller-->
<!-- Modal -->
<div class="modal fade" id="editSellerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form id="sellerUpdateForm" action="" method="get" enctype="multipart/form-data">
          @csrf
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel">Edit Seller Details</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
            
            <h5>Seller Account</h5>
            <input type="hidden"  name="id" value="{{$seller->id}}">
            <div class="row">
                <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('First Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="firstName" value="{{$seller->f_name}}"  required>
                            </div>
                </div>
                <div class="col-lg-3 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Last Name')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="lastName" value="{{$seller->l_name}}"  required>
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
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="shopContact" value="{{$seller->shop->contact}}">
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-4 mb-lg-0">
                        <div class="form-group">
                                <label for="exampleFirstName" class="title-color d-flex gap-1 align-items-center">{{\App\CPU\translate('Address')}}</label>
                                <input type="text" class="form-control form-control-user" id="exampleFirstName" name="shopAddress" value="{{$seller->shop->address}}">
                            </div>
                </div>
                
            </div>
            
            
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>
    
    
@endsection

@push('script')
    <script>
        function editSeller(){
            
            $('#editSellerModal').modal('show')
        }
        
    
     $('#sellerUpdateForm').on('submit', function(e) {
          $("body").addClass("loading"); 
        e.preventDefault();
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "{{route('admin.sellers.edit-seller-record')}}",
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response,"response")
                if(response =='updated'){
                    $("body").removeClass("loading"); 
                    window.location.reload()
                                // $('#editSellerModal').modal('hide');

                }
            },
            error: function(xhr, status, error) {
                // handle error response
            }
        });
    }); 
    </script>
@endpush
