<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\apartment;
use App\building;
use App\appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DB;

class apartment_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function show_add(){
        $buildings=building::all();
        return view("apartments.add" , compact("buildings"));
    }
    function add(Request $request){
        try{
            if(apartment::where("name",$request->name)->where("building_id",$request->building_id)->exists()){
                return 'info';
            }
            $apartment= new apartment();
            $apartment->name=$request->name;
            $apartment->description=$request->description;
            $apartment->floor_number=$request->floor_number;
            $apartment->room_number=$request->room_number;
            $apartment->electric_id=$request->electric_id;
            $apartment->building_id=$request->building_id;
            $apartment->rent_val=$request->rent_val;
            $apartment->user_id = Auth()->User()->id;
            $apartment->save();
            $files=$request->attachments;
            foreach ($files as $key => $file) {
                $new_name = 'file-'.rand().Carbon::now("Asia/Riyadh")->timestamp.'.'.$file->getClientOriginalExtension();
                $file->move(public_path("files/apartments/$apartment->id"), $new_name);
            }
            $apartment->attachments="files/apartments/$apartment->id";
            $apartment->save();
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
    public function show_apartment($id){
        $apartment=apartment::find($id);
        $path = public_path("files\apartments\\".$apartment->id);
        $files =[];
        if(is_dir($path)){
            $files = File::allFiles($path);
        }
        $files = collect($files);
        $files = $files->map(function ($file){
            return $file = explode("public",$file)[1];
        });
        return view("apartments.show_apartment" , compact("apartment","files"));
    }
    public function show_apartments(Request $request){
        $distracts = DB::table('distracts')->get();
        $availables = building::whereRaw("
            id in(select building_id from apartments where id not in ( select apartment_id from contracts where active is true ))")->get();
        return view("apartments.available", compact("availables","distracts"));
    }
    function update_apartment(Request $request , $id){
        try{
            $apartment = apartment::find($id);
            $apartment->name = $request->name;
            $apartment->rent_val = $request->rent_val;
            $apartment->description = $request->description;
            $apartment->floor_number = $request->floor_number;
            $apartment->room_number = $request->room_number;
            $apartment->electric_id = $request->electric_id;
            $apartment->updated_at = Carbon::now("Asia/Riyadh");
            if($apartment->user_id == 0)
                $apartment->user_id = Auth()->User()->id;
            $files=$request->attachments;
            foreach ($files as $key => $file) {
                $new_name = 'file-'.rand().Carbon::now("Asia/Riyadh")->timestamp.'.'.$file->getClientOriginalExtension();
                $file->move(public_path("files/apartments/$apartment->id"), $new_name);
            }
            $apartment->attachments="files/apartments/$apartment->id";
            $apartment->save();
            $path = public_path("files\apartments\\".$apartment->id);
            $files =[];
            if(is_dir($path)){
                $files = File::allFiles($path);
            }
            $files = collect($files);
            $files = $files->map(function ($file){
                return $file = explode("public",$file)[1];
            });
            return response()->json([
                "success"=>"true",
                "files_img"=>$files
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
    function  emptying($id){
        try{
            $apartment = apartment::find($id);
            $apartment->contract->active=0;
            $apartment->contract->save();
            return 'true';
        }
        catch(\Exception $e){
            return response()->json([
                'title'    => 'هناك خطأ!!!',
                'message'  => $e->getMessage()
            ]);
        }
    }
    public function search(Request $request){
        $search_txt = $request->search_txt;
        $distract_id = $request->distract;
        $apartments = apartment::query()->with("building")
                                ->whereHas("building", function ($query) use ($distract_id) {
                                    if($distract_id!=""){
                                        $distract_id=explode(",",$distract_id);
                                        $query->whereIn('distract_id',$distract_id);
                                    }
                                })
                                ->whereHas("building", function ($query) use ($search_txt) {
                                    $query
                                        ->where('name','LIKE',"%$search_txt%")
                                        ->orWhere('description','LIKE',"%$search_txt%")
                                        ->orWhere('address','LIKE',"%$search_txt%")
                                        ->orWhere('notes','LIKE',"%$search_txt%");
                                })->where(function ($query)use ($distract_id) {
                                    $query
                                        ->whereHas("contract", function ($query){
                                            $query->whereActive(0);
                                        })
                                        ->orDoesntHave("contract");
                                })
                                ->orWhere(function ($query) use ($search_txt,$distract_id){
                                    $query
                                    ->whereHas("building", function ($query) use ($distract_id) {
                                        if($distract_id!=""){
                                            $distract_id=explode(",",$distract_id);
                                            $query->whereIn('distract_id',$distract_id);
                                        }
                                    })
                                    ->where(function ($query)use ($distract_id) {
                                        $query
                                            ->whereHas("contract", function ($query){
                                                $query->whereActive(0);
                                            })
                                            ->orDoesntHave("contract");
                                    })
                                    ->where(function ($query) use ($search_txt){
                                            $query
                                                ->where('name','LIKE',"%$search_txt%")
                                                ->orWhere('description','LIKE',"%$search_txt%")
                                                ->orWhere('floor_number','LIKE',"%$search_txt%")
                                                ->orWhere('room_number','LIKE',"%$search_txt%")
                                                ->orWhere('electric_id','LIKE',"%$search_txt%")
                                                ->orWhere('rent_val',$search_txt);
                                        });
                                })
                                ->get();
        if($apartments->count()==0){
            return response()->json([
                "status"=>"unsuccess",
                "result"=>"لم يتم العثور على نتائج لبحثك"
            ]);
        }
        else{
            return response()->json([
                "status"=>"success",
                "apartments"=>$apartments
            ]);
        }
    }
    function show_book_appointment($apartment_id){
        $apartment = apartment::with("building")->find($apartment_id);
        $path = public_path("files\apartments\\".$apartment->id);
        $files =[];
        if(is_dir($path)){
            $files = File::allFiles($path);
        }
        $files = collect($files);
        $files = $files->map(function ($file){
            return $file = explode("public",$file)[1];
        });
        return view("apartments.book_appointment",compact("apartment","files"));
    }
    function book_appointment($apartment_id , Request $request){
        $appointment = new appointment();
        $appointment->user_id = Auth()->id();
        $appointment->apartment_id = $apartment_id;
        $appointment->date = $request->selected_date." ".$request->time;
        $appointment->save();
        return $appointment;
    }
    function show_appointments(){
        if(Auth()->user()->hasRole("user")){
            $appointments = appointment::where("user_id",Auth()->id())->get();
        }
        else{
            $appointments = appointment::all();
        }
        return view("appointments.show",compact("appointments"));
    }
    function my_apartments(){
        $user = Auth()->User();
        $apartments = apartment::whereHas("contract",function($query) use ($user){
            $query->whereActive(1)->whereRenter_id($user->renter->id);
        })->get();
        return view("apartments.mine",compact("apartments"));
    }
    function del_file($id , Request $request){
        $filename = public_path($request->file);
        return File::delete($filename);
    }
}
