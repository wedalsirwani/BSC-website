<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\building;
use Carbon\Carbon;
use DB;

class building_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    function show_add(){
        $distracts=DB::table("distracts")->get();
        return view("buildings.add",compact("distracts"));
    }
    function add(Request $request){
        try{
            if(building::where("name",$request->name)->exists()){
                return 'info';
            }
            $building= new building();
            $building->name=$request->name;
            $building->description=$request->description;
            $building->address=$request->address;
            $building->address_url=$request->address_url;
            $building->notes=$request->notes;
            $building->distract_id=$request->distract;
            $building->user_id = Auth()->User()->id;
            $building->save();
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
    function show_buildings(){
        $buildings=building::orderBy('name')->get();
        return view("buildings.show" , compact("buildings"));
    }
    function show_building($id){
        $building=building::find($id);
        $distracts = DB::table("distracts")->get();
        return view("buildings.show_building" , compact("building","distracts"));
    }
    function update_building(Request $request , $id){
        try{
            $building = building::find($id);
            $building->name = $request->name;
            $building->description = $request->description;
            $building->address = $request->address;
            $building->address_url = $request->address_url;
            $building->notes = $request->notes;
            $building->distract_id = $request->distract;
            $building->updated_at = Carbon::now("Asia/Riyadh");
            if($building->user_id == 0)
                $building->user_id = Auth()->User()->id;
            $building->save();
            return response()->json(["success"=>"true"]);
        }
        catch(\Exception $e){
            return response()->json([
                'title'    => 'هناك خطأ!!!',
                'message'  => $e->getMessage(),
                'success'  => 'false',
            ]);
        }
    }

}
