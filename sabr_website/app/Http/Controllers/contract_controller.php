<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\renter;
use App\building;
use App\apartment;
use App\contract;
use App\payable_payment;
use Carbon\Carbon;
use URL;
use DB;

class contract_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function show($renter_id = null ,$apartment_id = null){
        if($renter_id == null){
            $renters=renter::all();
        }
        else{
            $renters=renter::where("id_number" , $renter_id)->first();
        }
        $buildings=[];
        $apartment=null;
        if($apartment_id == null){
            $all_buildings=building::all();
            foreach($all_buildings as $building){
                $apartments_count=apartment::where("building_id" , $building->id)
                    ->whereRaw("id in ( select apartment_id from contracts where active is true )")->count();
                if($apartments_count != $building->apartments()->count()){
                    array_push($buildings , $building);
                }
            }
        }
        else{
            $buildings=apartment::find($apartment_id)->building()->get();
            $apartment=apartment::with("building")->find($apartment_id);
        }
        return view("contracts.show" , compact("renters" , "buildings","apartment"));
    }
    function get_avialable_apartments($building_id){
        $apartments=apartment::where("building_id" , $building_id)
        ->whereRaw("id not in ( select apartment_id from contracts where active is true )")->get();
        return response()->json([
            "apartments" => $apartments
        ]);
    }
    function add(Request $request){
        $contract = new contract();
        $contract->apartment_id = $request->apartment;
        $contract->renter_id = $request->renter;
        $contract->start_date = Carbon::parse($request->start_date)->format("d-m-Y");
        $contract->hijri_start_date = Carbon::parse($request->h_start_date)->format("d-m-Y");
        $contract->end_date = Carbon::parse($request->end_date)->format("d-m-Y");
        $contract->hijri_end_date = Carbon::parse($request->h_end_date)->format("d-m-Y");
        $contract->rent_duration = $request->rent_duration;
        $contract->rent_unit = $request->rent_unit;
        $contract->rent_amount = $request->rent_amount;
        $contract->pay_repeat = $request->pay_repeat;
        $contract->active = 1;
        $contract->user_id = Auth()->User()->id;
        return DB::transaction(function () use ($contract){
            $contract->save();
            return $contract->add_payable_payments();
        });
    }
    function show_contracts(){
        $contracts=contract::all();
        return view("contracts.show" , compact("contracts"));
    }
    function show_contract($id){
        $contract=contract::find($id);
        return view("contracts.show_contract" , compact("contract"));
    }
    function upd_pay_rep($id, $pay_repeat){
        $contract = contract::find($id);
        $contract->pay_repeat = $pay_repeat;
        if($contract->user_id == 0)
            $contract->user_id = Auth()->User()->id;
        $contract->save();
        $contract->add_payable_payments();
    }
    function upd_contract_date(Request $request){
        $contract_id=$request->contract_id;
        $contract=contract::find($contract_id);
        $contract->hijri_start_date=$request->h_start_date;
        $uri = "http://api.aladhan.com/v1/hToG?date=$contract->hijri_start_date&adjustment=0";
        $response = \Httpful\Request::get($uri)->send();
        $date=$response->body->data->gregorian->date;
        $contract->start_date=$date;
        $contract->hijri_end_date=$request->h_end_date;
        $uri = "http://api.aladhan.com/v1/hToG?date=$contract->hijri_end_date&adjustment=0";
        $response = \Httpful\Request::get($uri)->send();
        $date=$response->body->data->gregorian->date;
        $contract->end_date=$date;
        $contract->save();
        payable_payment::where("contract_id", $contract_id)->delete();
        if($contract->pay_repeat != 0)
            $contract->add_payable_payments();
    }
    function change_apartment_renter($contract_id, $renter_id){
        $contract=contract::find($contract_id);
        $contract->renter_id=$renter_id;
        $contract->save();
    }
    function show_summary(){
        $renters = renter::all();
        return view("contracts.show_summary",compact("renters"));
    }
    function show_summary_contract($contract_id){
        $contract = contract::find($contract_id);
        return view("contracts.summary", compact("contract"));
    }
    function show_summary_renter($renter_id){
        $renter = renter::find($renter_id);
        return view("renters.summary", compact("renter"));
    }
    function show_pay($id){
        $contract = contract::find($id);
        $pay_amount= DB::table("payable_payments")->where([
            "contract_id"=>$id
            ,"status"=>"payable"])->sum("amount");
        $message ="عزيزي ".Auth()->User()->renter->name
                    ." يتوجد عليك دفع مبلغ {$pay_amount}
                     ريال دفعة من قيمة إيجار الشقة {$contract->apartment->name}
                     -عمارة {$contract->apartment->building->name} للمتابعة أدخل معلومات الدفع";
        return view("contracts.pay",compact("message","id"));
    }
    
}
