<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\config;
use App\account;
use DB;
use Carbon\Carbon;

class user_controller extends Controller
{
    public function email_exists($email){
        return User::where('email',$email)->exists();
    }
    public function mobile_exists($mobile){
        return User::where('mobile_phone',$mobile)->exists();
    }
    public static function all(){
        return User::where('id','<>',Auth()->User()->id)->get();
    }
    public static function all_all(){
        return User::all();
    }
    public function user_roles($user_id){
        return response()->json([
            'roles'    => User::where('id',$user_id)->first()->role,
            'success'  => 'true',
        ]);
    }
    public function set_role($user_id , $role_id , $enabled){
        if($enabled=='true'){
            DB::table('users_roles')->insert([
                'user_id' => $user_id , 'role_id' => $role_id , 'created_at' => Carbon::now('Asia/Riyadh')
            ]);
        }
        else{
            DB::table('users_roles')->where('user_id',$user_id)->where('role_id',$role_id)->delete();
        }
        return 'تمت العملية بنجاح';
    }
    public function show_new(){
        $users=User::where('active',0)->where('id','<>',Auth()->User()->id)->get();
        return view('users.new_users',compact('users'));
    }
    public function show_all(){
        $users=User::where('id','<>',Auth()->User()->id)->get();
        $all=true;
        return view('users.new_users',compact('users','all'));
    }
    function set_active($user_id,$enable){
        $active=$enable=='true';
        $user=User::find($user_id);
        $user->active=$active;
        $user->save();
        return 'تم الحفظ بنجاح';
    }
    function show_config(){
        $config=config::first();
        return view('config.show_config',compact('config'));
    }
    function save_config(Request $request){
        try{
            $fee=$request->fee;
            $min=$request->min;
            $max=$request->max;
            $iban=$request->iban;
            if(!config::first()){
                $config=new config();
                $config->fee=$fee;
                $config->min_transaction=$min;
                $config->max_transaction=$max;
                $config->fund_iban=$iban;
                $config->save();
            }
            else{
                $config=config::first();
                $config->fee=$fee;
                $config->min_transaction=$min;
                $config->max_transaction=$max;
                $config->fund_iban=$iban;
                $config->save();
            }
            if(!account::where('user_id',0)->exists()){
                $account=new account();
                $account->account=$iban;
                $account->bank_id=1;
                $account->user_id=0;
                $account->created_at=Carbon::now('Asia/Riyadh');
                $account->updated_at=null;
                $account->save();
            }
            else{
                $account=account::where('user_id',0)->first();
                $account->account=$iban;
                $account->bank_id=1;
                $account->user_id=0;
                $account->created_at=Carbon::now('Asia/Riyadh');
                $account->updated_at=null;
                $account->save();
            }
            return response()->json([
                'message'    => 'تم حفظ الإعدادات',
                'class'  => 'alert alert-success',
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                'message'    => $e->getMessage(),
                'class'  => 'alert alert-danger',
            ]);
        }
    }
    function show_user_conf(){
        return view('config.user_config');
    }
}
