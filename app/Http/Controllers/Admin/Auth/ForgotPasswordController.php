<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Model\Admin;
use Gregwar\Captcha\PhraseBuilder;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordResetMail;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }
    
    public function forgotPassword(){
    
        return view('admin-views.auth.forgot-password');
    }
    
    public function sendForgotPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We could not find a user with that email address.']);
        }

        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'identity' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'user_type' => 'admin'
            
        ]);
        $url = env('APP_NAME').'admin/auth/reset-password/'.$token;
        
        try{
            Mail::to($user->email)->send(new PasswordResetMail($url));
            Toastr::success('Please check your E-Mail to Reset Password');
        } catch (\Exception $exception) {
            // Toastr::success($exception->getMessage());
        }

        return redirect(route('admin.auth.login'));
    }
    public function showResetForm(Request $request,$token){
        return view('admin-views.auth.reset-password-form',compact('token'));
    }
    public function reset(Request $request){
        // dd($request->all());
       $request->validate([
         'password' => 'required| min:4 |confirmed',
        'password_confirmation' => 'required| min:4'
    ]);
   $token =  $request->token_password;
//   dd($token);
   $admin=  DB::table('password_resets')->where('token',$token)->first();
   if($admin){
    $user = Admin::where('email', $admin->identity)->first();
       $user->update(['password'=>Hash::make($request->password)]);
               Toastr::success('Password Updated Successfully');
               return redirect(route('admin.auth.login'));

   }else{
     return back()->withErrors(['email' => 'Something went wrong']);  
   }
           

    }
    
    
}
