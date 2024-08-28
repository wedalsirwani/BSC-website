<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\renter;
use App\apartment;
use Carbon\Carbon;

class renter_controller extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth');
    }
    function show_add(){
        return view("renters.add");
    }
    function add(Request $request){
        try{
            $renter= new renter();
            $renter->name=$request->name;
            $renter->id_number=$request->id_number;
            $renter->phone_number=$request->phone;
            $file=$request->attachment;
            $new_name = 'file-'.rand().Carbon::now("Asia/Riyadh")->timestamp.'.'.$file->getClientOriginalExtension();
            $file->move(public_path('files'), $new_name);
            $renter->attachment="files/{$new_name}";
            $renter->user_id = Auth()->User()->id;
            $renter->save();
            return 'success';
        }
        catch(\Exception $e){
            return response()->json([
                'title'    => 'هناك خطأ!!!',
                'message'  => $e->getMessage(),
                'icon'  => 'error',
            ]);
        }
    }
    function renter_exists($id_number){
        if(renter::where("id_number" , $id_number)->exists()){
            return response()->json([
                "renter" => renter::where("id_number" , $id_number)->first()
            ]);
        }
        return 'not_exists';
    }
    function get_renter_apartments($renter_id){
        $apartments = apartment::whereRaw("id in ( select apartment_id from contracts where renter_id = $renter_id and active is true )")->get();
        $str="";
        foreach ($apartments as $key => $apartment) {
            $str.="<option value='$apartment->id'>".$apartment->building->name." - $apartment->name</option>";
        }
        return $str;
    }
    function show_all(){
        $renters =renter::orderBy("name")->get();
        return view("renters.show_all", compact("renters"));
    }
    function show_renter($id){
        $renter =renter::find($id);
        return view("renters.show_renter", compact("renter"));
    }
    function upd_renter($id, Request $request){
        try{
            if(renter::where("id", "<>", $id)->where("id_number", $request->id_number)->exists()){
                return response()->json([
                    "success"=>"false",
                    'title'    => 'عذراً',
                    'message'  =>'رقم الإقامة موجود مسبقاً',
                    'icon'  => 'error',
                ]);
            }
            if(renter::where("id", "<>", $id)->where("phone_number", $request->phone_number)->exists()){
                return response()->json([
                    "success"=>"false",
                    'title'    => 'عذراً',
                    'message'  =>'رقم الجوال مرتبط بمستأجر آخر.',
                    'icon'  => 'error',
                ]);
            }
            $renter=renter::find($id);
            $renter->name=$request->name;
            $renter->id_number=$request->id_number;
            $renter->phone_number=$request->phone_number;
            if($renter->user_id == 0)
                $renter->user_id == Auth()->User()->id;
            $renter->save();
            return response()->json([
                "success"=>"true",
                'title'    => 'تم بنجاح',
                'message'  =>'تحديث بيانات المستأجر.',
                'icon'  => 'info',
            ]);
        }
        catch(\Exception $e){
            return response()->json([
                "success"=>"false",
                'title'    => 'هناك خطأ!!!',
                'message'  => $e->getMessage(),
                'icon'  => 'error',
            ]);
        }
    }
    public static function all(){
        return response()->json(["renters"=>renter::all()]);
    }
    public function search(Request $request){
        $search = $request->search;
        $search = str_replace(' ', '%', $search);
        $search = str_replace('ا', '_', $search);
        $search = str_replace('أ', '_', $search);
        $search = str_replace('إ', '_', $search);
        $search = str_replace('ه', '_', $search);
        $search = str_replace('ة', '_', $search);
        $renters = renter::where("name", "like", "%$search%")
                        ->orWhere("id_number", "like", "%$search%")
                        ->orWhere("phone_number", "like", "%$search%")->orderBy("name")->get();
        $str="";
        foreach ($renters as $key =>$renter) {
            $str.=" <div class='col-lg-3 col-md-6 col-12 text-center'>
                        <a href='/renter/{$renter->id}' class='pri-color'>
                            <i class='fas fa-user fa-5x d-block'></i>
                            <p class='w-100 text-center h5 mt-3'>{$renter->name}</p>
                        </a>
                    </div>";
        }
       return $str;
    } 
} 