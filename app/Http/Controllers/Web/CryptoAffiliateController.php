<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\CryptoAffiliate;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\Helpers;
use Validator;
use Illuminate\Support\Facades\File;
use DB;
Use Exception;
use Illuminate\Support\Str;
use App\Model\Translation;
use Cache;

class CryptoAffiliateController extends Controller
{
    public function view()
    {
        $crypto_affiliates = CryptoAffiliate::paginate(6);
        // $sidebar_blogs = CryptoAffiliate::take(5)->latest()->get();
        return view('web-views.crypto-affiliate.view', compact('crypto_affiliates'));
    }

    public function show($id)
    {
        $crypto_affiliate = CryptoAffiliate::where('id', $id)->firstOrFail();
        $crypto_affiliates = CryptoAffiliate::where('id','!=',$id)->take(5)->latest()->get();
        return view('web-views.crypto-affiliate.show', compact('crypto_affiliate','crypto_affiliates'));
    }
}