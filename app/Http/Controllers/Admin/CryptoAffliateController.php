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

class BlogController extends Controller
{

    public function index(Request $request)
    {
        $query_param = [];
        $search = $request['search'];

        if ($request->has('search'))
        {
            $key = explode(' ', $request['search']);
            $blogs = Blog::where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->Where('title', 'like', "%{$value}%");
                }
            });
            
            $query_param = ['search' => $request['search']];
        }else{
            $blogs = new Blog();
        }
        $blogs = $blogs->latest()->paginate(Helpers::pagination_limit())->appends($query_param);
        return view('admin-views.blog.view',compact('blogs','search'));
    }

    // store
    function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'image'=>'nullable|image',
            'description'=>'required',
        ]);
        DB::beginTransaction();
        try{
            $blog = Blog::create($request->all());

            if($request->file('image'))
            {
                $blog->image = Helpers::upload_image($request->file('image'), 'blog/images');
                $blog->save();
            }

            DB::commit();
            Toastr::success('Blog added successfully!');
            return back();
        }
        catch (Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $blog = Blog::where('id', $id)->first();
        return view('admin-views.blog.edit', compact('blog'));
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
            Blog::where('id',$id)->update([
                'title'=>$req->title,
                'description'=>$req->description,
            ]);
            
            if ($req->hasFile('image')) {

                Helpers::delete_previous_image($blog->image);
                $blog->image = Helpers::upload_image($req->file('image'), 'blog/images');
                $blog->save();
            }

            DB::commit();
            Toastr::success('Blog added successfully!');
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
        $blog = Blog::find($request->id);
        if ($blog->image) {
            Helpers::delete_previous_image($blog->image);
        }
        $blog->delete();
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
