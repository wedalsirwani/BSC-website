<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Session;
use URL;
use Auth;
use Mail;
use DB;
use registeration_controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class login_controller extends Controller
{
    function show_set_pwd($email , $confirmation_code,$reset=null){
        if($reset==null){
            if(user::where('email',$email)->where('remember_token',$confirmation_code)->where('email_verified_at',null)->exists()){
                $name=user::where('email',$email)->where('remember_token',$confirmation_code)->first()->name;
                return view('pwd.set_pwd',compact('name','email'));
            }
            else{
                $error='الرابط لا يعمل!!!!';
                return view('pwd.set_pwd',compact('error'));
            }
        }
        else{
            if(user::where('email',$email)->where('remember_token',$confirmation_code)->exists()){
                $name=user::where('email',$email)->where('remember_token',$confirmation_code)->first()->name;
                return view('pwd.set_pwd',compact('name','email'));
            }
            else{
                $error='الرابط لا يعمل!!!!';
                return view('pwd.set_pwd',compact('error'));
            }
        }

    }
    function set_pwd(Request $request){
        try{
            $user=user::where('email',$request->email)->first();
            $user->password=bcrypt($request->pwd);
            $user->email_verified_at=Carbon::now('Asia/Riyadh');
            $user->updated_at=Carbon::now('Asia/Riyadh');
            $confirmation_code=registration_controller::generateRandomString(60);
            $user->remember_token=$confirmation_code;
            $user->save();
            Auth::attempt(['email' =>  $request->email, 'password' => $request->pwd, 'active' => 1]);
            return response()->json([
                'title'    => 'تم بنجاح',
                'message'  => 'تعيين كلمة المرور جاري إعادة توجيهك ...',
                'success'  => 'true',
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'title'    => 'هناك خطأ!!!',
                'message'  => $e->getMessage(),
                'success'  => 'false',
            ]);
        }
    }
    function show_login(Request $request){
        Session::forget('previous_url');
        Session::put('previous_url',URL::previous());
        if(Auth::check()){
            if(Session::get('previous_url') == url('').'/login' || Session::get('previous_url') == url('').'/register' || Session::get('previous_url') == ''){
                return Redirect::to('/');
            }
            return Redirect::to(Session::get('previous_url'));
        }
        else{
            return view('auth.login');
        }
    }
    function login(Request $request){
        try{
            if (Auth::attempt(['email' =>  $request->email, 'password' => $request->pwd, 'active' => 1])) {
                $url=Session::get('previous_url');
                if(Session::get('previous_url')==url('').'/login' || Session::get('previous_url')==url('').'/register' || Session::get('previous_url') == ''){
                    $url=url('');
                }
                return response()->json([
                    'url'      => $url,
                    'title'    => 'تم تسجيل الدخول!!!',
                    'message'  => 'جاري إعادة توجيهك ...',
                    'success'  => 'true',
                ]);
            }
            if(user::where('email',$request->email)->exists()){
                if(!user::where('email',$request->email)->first()->active){
                    return response()->json([
                        'title'    => 'تم إيقاف حسابك!!!',
                        'message'  => 'عذراً راجع الإدارة',
                        'success'  => 'false',
                    ]);
                }
            }
            return response()->json([
            'title'    => 'دخول خاطئ!!!',
            'message'  => 'خطأ في اسم المستخدم أو كلمة المرور.',
            'success'  => 'false',
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'title'    => 'هناك خطأ!!!',
                'message'  => $e->getMessage(),
                'success'  => 'false',
            ]);
        }
    }
    public function logout(){
        Auth::logout();
        return Redirect::to(Session::get('previous_url'));
    }
    public function show_reset_pwd(){
        return view('auth.reset_password');
    }
    public function reset_pwd($email){
        if(User::where('email',$email)->exists()){
            $user=User::where('email',$email)->first();
            $confirmation_code=registration_controller::generateRandomString(60);
            $user->remember_token=$confirmation_code;
            $user->save();
            Mail::send('auth.rst_pwd_template',
                            array('to' =>$email,'confirmation_code' =>$confirmation_code, 'name' =>$user->name),
                            function ($message) use ($email,$confirmation_code) {
                                $message
                                ->to($email,$email)
                                ->subject(config('app.name').' | إعادة تعيين كلمة المرور');
                            });
            return response()->json([
                'title'    => 'تم بنجاح',
                'message'  => 'إرسال رسالة إلى بريدك الالكتروني.',
                'success'  => 'true',
                ]);
        }
        return response()->json([
            'title'    => 'خطأ',
            'message'  => 'لم يتم التعرف على البريد الالكتروني.',
            'success'  => 'false',
            ]);
    }
    
    function check_pwd(Request $request){
        $user=user::find(Auth()->User()->id);
        if (Hash::check($request->pwd, $user->password))
        {
            return response()->json([
                'email'    => $user->email,
                'token'  => $user->remember_token
            ]);
        }
        return 'false';
    }
}
