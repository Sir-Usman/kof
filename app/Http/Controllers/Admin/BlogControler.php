<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Blog};
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use App\Helpers\Helper;
use DB;
use Session;
Use Exception;

class BlogControler extends Controller
{
    // store
    function store(Request $req)
    {
        $req->validate([
            'title'=>'required',
            'image'=>'nullable|image',
            'description'=>'required',
        ]);
        DB::beginTransaction();
        try{
            $blog = Blog::create($req->all());

            if($req->file('image'))
            {
                $blog->image = Helper::upload_image($req->file('image'), 'blog/images');
                $blog->save();
            }

            DB::commit();
            return redirect()->back()->with('message','Blog Added Successfully...');
        }
        catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    // edit
    function edit()
    {
        return 1;
    }

    // update
    function update(Request $req,$id)
    {
        $req->validate([
            'title'=>'required',
            'image'=>'nullable|image',
            'description'=>'required',
        ]);

        DB::beginTransaction();
        try{

            $blog = Blog::find($id);
            Blog::where('id',$id)->update($req->except(['image']));
            
            if ($req->hasFile('image')) {

                Helper::delete_previous_image($blog->image);
                $blog->image = Helper::upload_image($req->file('image'), 'blog/images');
                $blog->save();
            }

            DB::commit();
            return redirect()->back()->with('message','Blog Updated Successfully...');
        }
        catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    // delete 
    function delete_blog($id)
    {
        $blog = Blog::find($id);
        if ($blog->image) {
            Helper::delete_previous_image($blog->image);
        }
        // cart items
        // $cart = Cart::where('prod_id',$id)->get();
        // if($cartItems){ $cartItems->each->delete(); }
        $blog->delete();
        return redirect()->back()->with('message','Blog Deleted Successfully...');
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
