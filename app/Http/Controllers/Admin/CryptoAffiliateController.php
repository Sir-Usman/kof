<?php

namespace App\Http\Controllers\Admin;

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

class CryptoAffiliateController extends Controller
{

    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];

        if ($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $crypto_affiliates = CryptoAffiliate::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('title', 'like', "%{$value}%");
                }
            });
            
            $query_param = ['search' => $request['search']];
        }else{
            $crypto_affiliates = new CryptoAffiliate();
        }
        $crypto_affiliates = $crypto_affiliates->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.crypto-affiliate.view',compact('crypto_affiliates','search'));
    }

    // store
    function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'affiliate_link'=>'required',
            'image'=>'nullable|image',
            'description'=>'required',
        ]);
        DB::beginTransaction();
        try{
            $crypto_affiliate = CryptoAffiliate::create($request->all());

            if($request->file('image'))
            {
                $crypto_affiliate->image = Helpers::upload_image($request->file('image'), 'blog/images');
                $crypto_affiliate->save();
            }

            DB::commit();
            Toastr::success('Crypto Affiliate link added successfully!');
            return back();
        }
        catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $crypto_affiliate = CryptoAffiliate::where('id', $id)->first();
        return view('admin-views.crypto-affiliate.edit', compact('crypto_affiliate'));
    }

    // update
    function update(Request $req,$id)
    {
        $req->validate([
            'title'=>'required',
            'affiliate_link'=>'required',
            'image'=>'nullable|image',
            'description'=>'required',
        ]);

        DB::beginTransaction();
        try{

            $crypto_affiliate = CryptoAffiliate::find($id);
            CryptoAffiliate::where('id',$id)->update([
                'title'=>$req->title,
                'affiliate_link'=>$req->affiliate_link,
                'description'=>$req->description,
            ]);
            
            if ($req->hasFile('image')) {

                Helpers::delete_previous_image($crypto_affiliate->image);
                $crypto_affiliate->image = Helpers::upload_image($req->file('image'), 'blog/images');
                $crypto_affiliate->save();
            }

            DB::commit();
            Toastr::success('Crypto Affiliate updated successfully!');
            return back();
        }
        catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    // delete 
    function delete(Request $request)
    {
        $crypto_affiliate = CryptoAffiliate::find($request->id);
        if ($crypto_affiliate->image) {
            Helpers::delete_previous_image($crypto_affiliate->image);
        }
        $crypto_affiliate->delete();
        return response()->json();
    }

    public function store_ck_Image(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
    
            $request->file('upload')->move(public_path('media'), $fileName);
    
            $url = asset('media/' . $fileName);
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}
