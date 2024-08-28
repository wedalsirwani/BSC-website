<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\transaction;
use DB;
use Carbon\Carbon;
use App\User;
use App\renter;
use App\contract;
use App\reject_reason;
use App\Notifications\new_transaction;
use App\Notifications\approved_transaction;
use App\Events\new_event_transaction;
use App\Events\transaction_approved;
use App\notification;
use App\config;
use App\payable_payment;
use App\benefit;

class transaction_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function format_iban(){
        $config=config::first();
        $temp=str_split($config->fund_iban);
        $config->fund_iban="";
        $last = count($temp);
        foreach($temp as $index=>$char){
            if( $index == $last-1 || $index===0 ) {
                $config->fund_iban.=$char;
            }
            else {
                if($index%4==0){
                        $config->fund_iban.="-";
                }
                $config->fund_iban.=$char;
            }
        }
        $temp=str_split($config->fund_acc);
        $config->fund_acc="";
        $last = count($temp);
        foreach($temp as $index=>$char){
            if( $index == $last-1 || $index===0 ) {
                $config->fund_acc.=$char;
            }
            else {
                if($index%4==0){
                        $config->fund_acc.="-";
                }
                $config->fund_acc.=$char;
            }
        }
        return $config;
    }
    function show_add($id = 0){
        $renters=renter::whereRaw("id in ( select renter_id from contracts where active is true)")->get();
        $contract=null;
        if($id != 0){
            $contract=contract::find($id);
        }
        return view('transactions.add' , compact('renters' , 'contract'));
    }
    function add_transaction($contract_id =null , Request $request){
        try{
            return DB::transaction(function () use ($contract_id ,$request) {
                $renter=null;
                $apartment=null;
                $amount=null;
                $transaction_date=null;
                $hijri_transaction_date=null;
                $description=null;
                $received_by=null;
                $notes=null;
                if($contract_id == null){
                    $renter=$request->renter;
                    $apartment=$request->apartment;
                    $amount=$request->amount;
                    $transaction_date=Carbon::parse($request->transaction_date)->format("d-m-Y");
                    $hijri_transaction_date=Carbon::parse($request->hijri_transaction_date)->format("d-m-Y");
                    $description=$request->description;
                    $received_by=$request->received_by;
                    $notes=$request->notes;
                    $contract_id=contract::where("renter_id" , $renter)->where("apartment_id" , $apartment)
                        ->where("active" , "1")->first()->id;
                }
                else{
                    $contract = contract::find($contract_id);
                    $renter=$contract->renter_id;
                    $apartment=$contract->apartment_id;
                    $pay_amount= DB::table("payable_payments")->where([
                        "contract_id"=>$contract_id
                        ,"status"=>"payable"])->sum("amount");
                    $amount=$pay_amount;
                    $transaction_date=Carbon::now("Asia/Riyadh")->format("d-m-Y");
                    $uri = "http://api.aladhan.com/v1/hToG/$transaction_date?date=$transaction_date&adjustment=0";
                    $response = \Httpful\Request::get($uri)->send();
                    $date=$response->body->data->gregorian->date;
                    $hijri_transaction_date=$date;
                    $description="دفعة من قيمة عقد الايجار رقم {$contract_id}";
                    $received_by="online_payment";
                    $notes="card-number={$request->card_number}/card-expiry={$request->card_expiry}/cvv={$request->cvv}";
                }
                $transaction=new transaction();
                $transaction->contract_id=$contract_id;
                $transaction->amount=$amount;
                $transaction->transaction_date=$transaction_date;
                $transaction->hijri_transaction_date=$hijri_transaction_date;
                $transaction->description=$description;
                $transaction->received_by=$received_by;
                $transaction->notes=$notes;
                $transaction->user_id=Auth()->id();
                $transaction->transaction_number="الأصل";
                $transaction->created_at=Carbon::now('Asia/Riyadh');
                $transaction->updated_at=null;
                $transaction->save();
                while($amount >= payable_payment::where("contract_id", $contract_id)->where("status", "<>", "paied")->first()->amount){
                    if( $amount >= payable_payment::where("contract_id", $contract_id)->where("status", "<>", "paied")->first()->amount){
                        $payable=payable_payment::where("contract_id", $contract_id)->where("status", "<>", "paied")->first();
                        $payable->status="paied";
                        $payable->save();
                        $amount-=$payable->amount;
                    }
                }
                //check if cotract ended

                //send sms

                return response()->json([
                    'transaction_id'=>$transaction->id,
                    'success'  => 'true',
                    'renter_id'=>Auth()->User()->renter->id
                ]);
            });
        }
        catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function show_add_amount($contract_id){
        $contract = contract::find($contract_id);
        $renters=renter::whereRaw("id in ( select renter_id from contracts where active is true)")->get();
        return view("transactions.add_amount", compact("renters", "contract"));
    }
    public function add_amount(Request $request){
        $benefit = new benefit();
        $benefit->contract_id = $request->contract_id;
        $benefit->amount = $request->amount;
        $benefit->description = $request->description;
        $benefit->notes = $request->notes;
        $benefit->user_id = Auth()->id();
        $benefit->created_at = Carbon::now("Asia/Riyadh");
        $benefit->updated_at = null;
        $benefit->save();
        return response()->json([
            'success'  => 'true',
        ]);
    }
    public function show_transaction($id=null){
        $error='ليس لديك الصلاحية للدخول على هذه الصفحة.';
        if($id!=null){
            $transactions=transaction::where('id',$id)->get();
            $user_id=account::find($transactions[0]->from_acc)->user_id;
            if(Auth()->User()->hasRole('employee') || Auth()->User()->hasRole('admin') || Auth()->User()->id==$user_id){
                return view('transactions.show_transaction',compact('transactions'));
            }
            else{
                return view('transactions.show_transaction',compact('error'));
            }
        }
        else{
            $transactions=transaction::where('approved',null)->get();
            if(Auth()->User()->hasRole('employee') || Auth()->User()->hasRole('admin')){
                return view('transactions.show_transaction',compact('transactions'));
            }
            else{
                return view('transactions.show_transaction',compact('error'));
            }
        }
    }
    function change_transaction(Request $request){
        $id=$request->id;
        $auth_user_id=Auth()->User()->id;
        $user_id=transaction::find($id)->account->User->id;
        if($auth_user_id==$user_id){
            return 'same_user';
        }
        $val=$request->val;
        if($val==0){
            if(reject_reason::where("transaction_id",$id)->exists()){
                reject_reason::where("transaction_id",$id)->update([
                    "reason"=>$request->text,
                    "updated_at"=>Carbon::now("Asia/Riyadh")
                ]);
            }
            else{
                reject_reason::insert([
                    "transaction_id"=>$id,
                    "reason"=>$request->text,
                    "created_at"=>Carbon::now("Asia/Riyadh")
                ]);
            }
        }
        else{
            reject_reason::where("transaction_id",$id)->delete();
        }
        DB::table('transactions')->where('id',$id)->update([
            'approved'=> $val , 'approved_date'=> Carbon::now('Asia/Riyadh') ,'approved_user' => Auth()->User()->id , 'updated_at' => Carbon::now('Asia/Riyadh')
        ]);
        $user=User::find(DB::table('accounts')->whereRaw('id in (select from_acc from transactions where id='.$id.')')->first()->user_id);
        \Notification::send($user, new approved_transaction($user->name,$id,$val));
        $notification_id=DB::table('notifications')->where('notifiable_id',$user->id)
            ->whereRaw('created_at in ( select max(created_at) from notifications where notifiable_id='.$user->id.')')->get()[0]->id;
        $str='رفض';
        if($val){
            $str='اعتماد';
        }
        event(new transaction_approved(['user'=>$user->name,'transaction_id'=>$id,'approved'=>$str],$user->id,$notification_id));
        return 'true';
    }
    function get_transactions(Request $request){
        $users=explode(",", $request->users);
        $from=$request->from_date;
        $to=$request->to_date;
        $conditions='1';
        if($users!=[""]){
            foreach($users as $user){
                if(head($users)==$user){
                    $conditions='from_acc in ( select id from accounts where user_id = '.$user;
                }
                else {
                    $conditions.=' or user_id = '.$user;
                }
            }
            $conditions.=' )';
        }
        if($to=='' || $to=='Invalid date'){
            $to=transaction::max('transaction_date');
        }
        if($from=='' || $from=='Invalid date'){
            $from=transaction::min('transaction_date');
        }
        $transactions=transaction::whereBetween('transaction_date',[$from,$to])->whereRaw($conditions)->get();
        return transaction_controller::print_transactions($transactions);
    }
    function get_unapproved_transactions(){
        return transaction_controller::print_transactions(transaction::where('approved',null)->get());
    }
    function get_my_transactions(Request $request){
        $conditions='from_acc in ( select id from accounts where user_id = '.Auth()->User()->id.' )';
        $from=$request->from_date;
        $to=$request->to_date;
        $transactions=transaction::whereBetween('transaction_date',[$from,$to])->whereRaw($conditions)->get();
        return transaction_controller::print_transactions($transactions);
    }
    public static function print_transactions($transactions){
        $output='<tr><th>#</th><th>الدفعة</th><th>من حساب</th><th>إلى حساب</th><th>تاريخ التحويل</th><th>الموافق</th>
        <th>التاريخ</th><th>قبول / رفض الدفعة</th>';
        if(Auth()->User()->hasRole('admin')){
            $output.='<th class="text-center">معتمد / رافض الدفعة</th><th class="text-center">التاريخ</th>';
        }
        $output.='<th class="text-center" title="إظهار أو إخفاء الإيصال">
        <i class="far fa-eye"></i> \ <i class="far fa-eye-slash"></i></th></tr>';
        foreach ($transactions as $index=>$transaction){
            $output.='<tr>
                <th scope="row">'.++$index.'</th>
                <td>'.$transaction->amount.'</td>
                <td>
                    <p>';
                    $output.=DB::table('accounts')->where('id',$transaction->from_acc)->first()->account.'</p>
                    <p class="badge ';
                    if(!DB::table('users')->whereRaw('id in(select user_id from accounts where id='.$transaction->from_acc.')')->exists())
                    $output.='badge-success';
                    else $output.='badge-info';
                    $output.='">';
                    if(DB::table('users')->whereRaw('id in(select user_id from accounts where id='.$transaction->from_acc.')')->exists())
                    $output.=DB::table('users')->whereRaw('id in(select user_id from accounts where id='.$transaction->from_acc.')')->first()->name;
                        else $output.='حساب الصندوق' ;
                    $output.='</p>
                </td>
                <td>
                    <p>';
                    $output.=DB::table('accounts')->where('id',$transaction->to_acc)->first()->account.'</p>
                    <p class="badge ';if(DB::table('users')->whereRaw('id in(select user_id from accounts where id='.$transaction->from_acc.')')->exists())
                    $output.='badge-success';
                    else $output.='badge-info';
                    $output.='">';
                    if(DB::table('users')->whereRaw('id in(select user_id from accounts where id='.$transaction->to_acc.')')->exists())
                    $output.=DB::table('users')->whereRaw('id in(select user_id from accounts where id='.$transaction->to_acc.')')->first()->name;
                        else $output.='حساب الصندوق' ;
                    $output.='</p>
                </td>
                <td>'.$transaction->hijri_transaction_date.'</td>
                <td>'.$transaction->transaction_date->toDateString().'</td>';
                $output.='<td  title="'.$transaction->created_at->toTimeString().'"><p class="badge badge-light">'.$transaction->created_at->toDateString().'</p></td>
                    <td';
                    if($transaction->approved === 0){
                        $output.=" title='سبب الرفض: {$transaction->reject_reason->reason}'";
                    }
                    $output.='><div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="accept'.$transaction->id.'" name="control'.$transaction->id.'" value="1" onchange="change_transaction('.$transaction->id.');"';
                if($transaction->approved){
                    $output.=' checked';
                }
                if(!Auth()->User()->hasRole('admin') && !Auth()->User()->hasRole('employee')){
                    $output.=' disabled';
                }
                $output.='>
                            <label class="custom-control-label" for="accept'.$transaction->id.'">قبول</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="rej'.$transaction->id.'" name="control'.$transaction->id.'" value="0" onchange="change_transaction('.$transaction->id.');"';
                if($transaction->approved === 0){
                    $output.=" checked";
                }
                if(!Auth()->User()->hasRole('admin') && !Auth()->User()->hasRole('employee')){
                    $output.=' disabled';
                }
                $output.='>
                            <label class="custom-control-label" for="rej'.$transaction->id.'">رفض</label>
                        </div>
                    </td>';
                    $user=user::find($transaction->approved_user) !=null? user::find($transaction->approved_user)->name:'';
                    $approved_date=$transaction->approved_date ? $transaction->approved_date->toDateString() : '';
                    $approved_time=$transaction->approved_date ? $transaction->approved_date->toTimeString() : '';
                    $colspan=9;
                    if(Auth()->User()->hasRole('admin')){
                        $output.='<td class="text-center">'.$user.'</td><td class="text-center" title="'.$approved_time.'">'.$approved_date.'</td>';
                        $colspan=11;
                    }
                    $output.='<td class="text-center"><button class="btn btn-custom p-0" style="min-width: 30px" onclick="toggle_img('.$transaction->id.')"><i id="i'.$transaction->id.'" title="إظهار الإيصال" class="far fa-eye cursor-p"></i></button></td>
                    </tr>';
                $output.='<tr class="table-warning d-none" id="tr'.$transaction->id.'"><td class="text-center" colspan="'.$colspan.'"><img class="img-fluid" src="'.asset($transaction->receipt).'"/></td></tr>';
            }
        return $output;
    }
    public function show_my_balance(){
        $user_id=Auth()->User()->id;

        $my_balance=transaction::where('from_acc',Auth()->User()->id)->where("approved",1)->sum('amount')-loan::where('user_id',Auth()->User()->id)->sum('amount');
        $config=$this->format_iban();
        $sum_transactions=transaction::whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_transactions=transaction::whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');

        $sum_approved_transactions=transaction::where('approved',1)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_approved_transactions=transaction::where('approved',1)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');

        $sum_rejected_transactions=transaction::where('approved',0)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_rejected_transactions=transaction::where('approved',0)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');

        $sum_unapproved_transactions=transaction::where('approved',null)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_unapproved_transactions=transaction::where('approved',null)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');
        $last_loan=0;
        $sum_loans=loan::where('user_id',$user_id)->sum('amount');
        if(loan::where('user_id',$user_id)->whereRaw("id in (select max(id) from loans where user_id={$user_id})")->exists())
            $last_loan=loan::where('user_id',$user_id)->whereRaw("id in (select max(id) from loans where user_id={$user_id})")->first()->amount;
        $count_loans=loan::where('user_id',$user_id)->count('amount');

        $your_balance= $sum_approved_transactions-$sum_loans;
        return view('transactions.my_balance',compact('sum_transactions','count_transactions',
        'sum_approved_transactions','count_approved_transactions',
        'sum_unapproved_transactions','count_unapproved_transactions',
        'sum_rejected_transactions','count_rejected_transactions',
        'sum_loans','count_loans',
        'your_balance','my_balance','config','last_loan'));
    }
    function show_balnce(){
        return view("transactions.balance");
    }
    function get_balance($user_id){
        $my_balance=transaction::where('from_acc',Auth()->User()->id)->where("approved",1)->sum('amount')-loan::where('user_id',Auth()->User()->id)->sum('amount');
        $config=$this->format_iban();
        $sum_transactions=transaction::whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_transactions=transaction::whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');

        $sum_approved_transactions=transaction::where('approved',1)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_approved_transactions=transaction::where('approved',1)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');

        $sum_rejected_transactions=transaction::where('approved',0)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_rejected_transactions=transaction::where('approved',0)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');

        $sum_unapproved_transactions=transaction::where('approved',null)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->sum('amount');
        $count_unapproved_transactions=transaction::where('approved',null)->whereRaw('from_acc in ( select id from accounts where user_id = '.$user_id.' )')->count('amount');
        $last_loan=0;
        $sum_loans=loan::where('user_id',$user_id)->sum('amount');
        if(loan::where('user_id',$user_id)->whereRaw("id in (select max(id) from loans where user_id={$user_id})")->exists())
            $last_loan=loan::where('user_id',$user_id)->whereRaw("id in (select max(id) from loans where user_id={$user_id})")->first()->amount;
        $count_loans=loan::where('user_id',$user_id)->count('amount');
        $your_balance= $sum_approved_transactions-$sum_loans;
        $User=User::find($user_id);
        $result="<div class='profile'>
        <div class='row'>
            <div class='col-lg-7 col-12 mr-auto ml-auto'>
                <div class='profile-circle float-right'>
                    <i class='fas fa-user fa-4x m-auto'></i>
                </div>
                <div class='profile-user float-right mt-5 mr-3'>
                    <p>{$User->name}</p>
                    <p>تاريخ التسجيل {$User->email_verified_at->format('d-m-Y')}</p>
                </div>
            </div>
        </div>
        </div>
        <div class='row text-right mt-5'>
        <div class='col-lg-7 col-12 mr-auto ml-auto'>
            <div class='row'>
                <div class='col-md-4'>
                    <p class='pri-color mb-0 font-1-5-rem'>{$count_approved_transactions}</p>
                    <p class='font-1-5-rem'>دفعات مؤكدة</p>
                </div>
                <div class='col-md-4'>
                    <p class='pri-color mb-0 font-1-5-rem'>{$count_unapproved_transactions}</p>
                    <p class='font-1-5-rem'>دفعات غير مؤكدة</p>
                </div>
                <div class='col-md-4'>
                    <p class='pri-color mb-0 font-1-5-rem'>{$count_rejected_transactions}</p>
                    <p class='font-1-5-rem'>دفعات مرفوضة</p>
                </div>
            </div>
        </div>
        </div>

        <div class='row text-right mt-5'>
        <div class='col-lg-7 col-12 mr-auto ml-auto'>
            <div class='row mt-3'>
                <div class='max-width-50 bg-master'>
                    <p>إضافة رصيد</p>
                    <i class='fas fa-money-check fa-2x d-inline-block float-left mt-2' style='line-height:2.5rem'></i>
                    <p class='slave-txt'>إضافة رصيد في الصندوق</p>
                    <p class='h2 balance mt-5 pt-5'>".number_format($my_balance,0)."</p>
                    <p class='slave-txt'>إجمالي المدخرات</p>
                    <p class='d-inline-block mb-4'>".substr(Auth()->User()->account->account,-4)."**</p>
                    <i class='far fa-credit-card fa-2x d-inline-block float-left'></i>
                    <div class='big-circle'>
                        <p class='h1'>+</p>
                    </div>
                </div>
                <div class='max-width-50 bg-slave'>
                    <p class='pri-color'p>طلب قرض</p>
                    <i class='fas fa-cash-register fa-2x d-inline-block float-left mt-2' style='line-height:2.5rem'></i>
                    <p class='slave-txt'>اطلب مستحقاتك من القروض</p>
                    <p>قيمة آخر قرض</p>
                    <p class='h3 font-weight-bold pri-color'>".number_format($last_loan,0)."</p>
                    <p>عدد القروض</p>
                    <p class='h3 font-weight-bold pri-color'>{$count_loans}</p>
                    <p>قيمة القروض</p>
                    <p class='h2 balance font-weight-bold pri-color'>".number_format($sum_loans,0)."</p>
                    <div class='big-circle'>
                        <p class='h1 pri-color'>-</p>
                    </div>
                </div>
            </div>
        </div>
        </div>";
        return $result;
    }
    public function print_preview_transaction($transaction_id ,$preview){
        $transaction=transaction::find($transaction_id);
        $preview=1;
        return view('transactions.print',compact('transaction', 'preview'));
    }
    public function print_transaction($transaction_id){
        $transaction=transaction::find($transaction_id);
        return view('transactions.print',compact('transaction'));
    }
}
