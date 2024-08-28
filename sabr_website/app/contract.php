<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\payable_payment;
use Carbon\Carbon;
use DB;

class contract extends Model
{
    public function renter(){
        return $this->belongsTo('App\renter');
    }
    public function benefits(){
        return $this->hasMany('App\benefit');
    }
    public function apartment(){
        return $this->belongsTo("App\apartment");
    }
    public function is_avialable($apartment_id){
        if(apartment::where("id" , $apartment_id)
        ->whereRaw("id not in ( select apartment_id from contracts where active is true )")->exists()){
            return true;
        }
        return false;
    }
    public function transactions(){
        return $this->hasMany('App\transaction');
    }
    public function remaining(){
        return $this->rent_amount-$this->transactions->sum("amount");
    }
    public function payable_this_contract(){
        $payables = payable_payment::where("status", "payable")->where("contract_id", $this->id)->sum('amount');
        $transactions=transaction::where("contract_id", $this->id)->sum("amount");
        return $payables-$transactions;
    }
    public function payable(){
        $contracts = contract::where(["renter_id" => $this->renter_id])->get();
        $contract_ids="";
        foreach ($contracts as $key => $contract) {
            $sum_transactions = transaction::where("contract_id", $contract->id)->sum('amount');
            if($contract->rent_amount > $sum_transactions){
                $contract_ids.=$contract->id.',';
            }
        }
        $contract_ids.="0";
        $payables = payable_payment::where("status", "payable")->whereRaw("contract_id in ({$contract_ids})")->sum('amount');
        $transactions=transaction::whereRaw("contract_id in ({$contract_ids})")->sum("amount");
        return $payables-$transactions;
    }
    public function payable_payment(){
        return $this->hasMany('App\payable_payment');
    }
    public function add_payable_payments(){

        if($this->rent_unit == 'سنة' || $this->rent_unit == 'شهر'){
            $rent_duration=$this->rent_duration;
            if($this->rent_unit == 'سنة' )
            {
                $rent_duration*=12;
            }
            $payable_H_date= $this->hijri_start_date;
            //$response = file_get_contents('http://example.com/path/to/api/call?param1=5');
            $payment_amount = $this->rent_amount / ($rent_duration/$this->pay_repeat);
            for($i=0; $i<12/$this->pay_repeat*($rent_duration/12);$i++){
                $payable_payment=new payable_payment();
                $payable_payment->contract_id=$this->id;
                $payable_payment->amount=$payment_amount;
                $uri = "http://api.aladhan.com/v1/hToG/$payable_H_date?date=$payable_H_date&adjustment=0";
                $response = \Httpful\Request::get($uri)->send();
                $date=$response->body->data->gregorian->date;
                $payable_payment->payable_date=$date;
                $payable_payment->payable_H_date=$payable_H_date;
                if($i==0) $payable_payment->status='payable';
                else $payable_payment->status='non-payable';
                $payable_payment->created_at=Carbon::now("Asia/Riyadh");
                $payable_payment->updated_at=null;
                $payable_payment->save();
                $payable_H_date=Carbon::parse($payable_H_date)->addMonths($this->pay_repeat)->format('d-m-Y');
            }
            return $this->id;
        }
    }
}
