<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Blog;
use Brian2694\Toastr\Facades\Toastr;
use App\CPU\Helpers;
use Validator;
use Illuminate\Support\Facades\File;
use DB;
Use Exception;
use Illuminate\Support\Str;
use App\Model\Translation;
use Cache;

class FrontBlogController extends Controller
{
    public function all_blogs()
    {
        $blogs = Blog::paginate(6);
        $sidebar_blogs = Blog::take(5)->get();
        return view('web-views.blog.view', compact('blogs','sidebar_blogs'));
    }

    public function single($id)
    {
        $blog = Blog::where('id', $id)->first();
        $blogs = Blog::where('id','!=',$id)->take(5)->get();
        return view('web-views.blog.single', compact('blog','blogs'));
    }
}