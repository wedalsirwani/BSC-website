<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class apartment extends Model
{
    protected $fillable=["rent_val"];
    public function building(){
        return $this->belongsTo("App\building");
    }
    public function contract(){
        return $this->hasOne("App\contract");
    }
    public function is_avialable(){
        $avialable=0;
        if($this->contract()->count() > 0){
            if(apartment::where("id" , $this->id)
                ->whereRaw("id not in ( select apartment_id from contracts where active is true )")->exists()
                ){
                    $avialable = 1;
            }
        }
        else{
            $avialable = 1;
        }
        return $avialable;
    }
}
