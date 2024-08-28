<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\offer;
use Carbon\Carbon;

class offer_controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function add(){
        return view("offers.add");
    }
    public function add_offer(Request $req){
        try{
            $offer_imge = $req->offer_img;
            $new_name = 'file-'.rand().Carbon::now("Asia/Riyadh")->timestamp.'.'.$offer_imge->getClientOriginalExtension();
            $offer_imge->move(public_path('files'), $new_name);
            $offer = new offer();
            $offer->caption=$req->caption;
            $offer->description=$req->description;
            $offer->offer_url=$req->offer_url;
            $offer->img="files/".$new_name;
            $offer->user_id=Auth()->id();
            $offer->save();
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
}
