<?php

namespace App\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;
use File;
use App\Models\{Blog};

class Helper extends Controller
{

    public static function upload_image($file, $path = '',  $name = null)
    {
        $ext = $file->getClientOriginalExtension();
        $filename = time().'.'.$ext;
        $file->move($path,$filename);
        $upload_path = $path.'/'.$filename;
        return url($upload_path);
    }


    public static function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    // // delete previous image
    // public static function delete_previous_image($pre_file)
    // {
    //     $path = str_replace(url('/').'/' , "", $pre_file);
    //     if(File::exists($path))
    //     {
    //         File::delete($path);
    //     }
    // }
}