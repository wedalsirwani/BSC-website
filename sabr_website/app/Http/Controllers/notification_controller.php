<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notification;
use Carbon\Carbon;

class notification_controller extends Controller
{
    public function make_as_read($id){
        $notification=notification::find($id);
        if($notification){
            $notification->read_at=Carbon::now('Asia/Riyadh');
            $notification->save();
        }
        if($id=='0'){
            notification::where('notifiable_id',Auth()->User()->id)->whereNull('read_at')->update([
                'read_at'=>Carbon::now('Asia/Riyadh')
            ]);
        }
    }
}
