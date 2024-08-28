<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\account;
use App\renter;
use Carbon\Carbon;
use DB;
use Mail;
use App\Notifications\new_register;
use App\Events\new_register_user;

class registration_controller extends Controller
{
    public function create(){
        return view('users.register');
    }
    public function save(Request $request){
        // try{
            DB::transaction(function () use ($request) {
                $user=new User();
                $user->name=$request->name;
                $user->sex=$request->sex;
                $user->social_status=$request->social_status;
                $user->mobile_phone=$request->mobile_phone;
                $user->email=$request->email;
                $user->id_num=$request->ID;
                $user->active=1;
                $user->password=bcrypt($request->mobile_phone);
                // $user->password=$request->mobile_phone;
                $user->remember_token=registration_controller::generateRandomString(60);
                $user->created_at=Carbon::now('Asia/Riyadh');
                $user->updated_at=null;
                $user->save();

                $renter = new renter();
                $renter->name=$request->name;
                $renter->id_number=$request->ID;
                $renter->phone_number=$request->mobile_phone;
                $renter->attachment="defualt";
                $renter->user_id=$user->id;
                $renter->created_at=Carbon::now('Asia/Riyadh');
                $renter->updated_at=null;
                $renter->save();

                DB::table('users_banks')->insert(
                    ['user_id' => $user->id , 'bank_id' => $request->bank]
                );
                DB::table('users_roles')->insert(
                    ['user_id' => $user->id , 'role_id' => 3 , 'created_at' => Carbon::now('Asia/Riyadh') ]
                );

                $account=new account();
                $account->account=$request->account;
                $account->bank_id=$request->bank;
                $account->user_id=$user->id;
                $account->created_at=Carbon::now('Asia/Riyadh');
                $account->updated_at=null;
                $account->save();
                $confirmation_code=$user->remember_token;
                $to=$user->email;
                $name =$user->name;
                Mail::send('email.confirm_email',
                            // array('to' =>$to,'confirmation_code' =>$confirmation_code, 'name' =>$user->name),
                            compact("to","confirmation_code", "name"),
                            function ($message) use ($to,$confirmation_code) {
                                $message
                                ->to($to,"")
                                ->subject(config('app.name').' | تأكيد بريدك الالكتروني')
                                // ->from(getenv('MAIL_FROM_ADDRESS'), config('app.name'))
                                ;
                            });
                $users=User::whereRaw('id in ( select user_id from users_roles where role_id = 2 or role_id = 1 )')->get();
                foreach($users as $item){
                    \Notification::send($item, new new_register($user->name,$item->name));
                    $notification_id=DB::table('notifications')->where('notifiable_id',$item->id)
                        ->whereRaw('created_at in ( select max(created_at) from notifications where notifiable_id='.$item->id.')')->get()[0]->id;
                    event(new new_register_user($item->id,$user->name,$notification_id));
                }
            });
            return response()->json([
                'title'    => 'تم بنجاح',
                'message'   => 'إرسال رسالة تأكيد إلى بريدك الالكتروني.',
                'success'  => 'true',
            ]);
        // }
        // catch(\Exception $e){
        //     return response()->json([
        //         'title'    => 'هناك خطأ!!!',
        //         'message'  => $e->getMessage(),
        //         'success'  => 'false',
        //     ]);
        // }
    }
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
