<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\apartment;
use App\maintanance_request;
class RequestController extends Controller
{
    public function show_request($apartment_id){
        $apartment = apartment::with("building")->find($apartment_id);
        return view("requests.show_request",compact("apartment"));
    }
    public function save($apartment_id , Request $req){
        $request = new maintanance_request();
        $request->user_id = Auth()->id();
        $request->apartment_id = $apartment_id;
        $request->date = $req->selected_date." ".$req->time;
        $types=["eletrical"=>'خدمات كهربائية',"plumbing"=>'خدمات سباكة',"move"=>'نقل أثاث'];
        $request->request_type = $types[$req->request_type];
        $request->request_status = "غير مكتمل";
        $request->request_description = $req->description;
        $request->save();
        return $request;
    }
    public function show_requests(){
        if(Auth()->user()->hasRole("user")){
            $requests = maintanance_request::where("user_id",Auth()->id())->get();
        }
        else{
            $requests = maintanance_request::all();
        }
        return view("requests.show",compact("requests"));
    }
    public function complate($id){
        return maintanance_request::find($id)->update([
            "request_status"=>"مكتمل"
        ]);
    }
}
