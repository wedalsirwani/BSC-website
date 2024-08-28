<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class building extends Model
{
    public function apartments(){
        return $this->hasMany("App\apartment")->orderByRaw('LENGTH(name) ASC')
        ->orderBy('name', 'ASC');
    }
    public function distract(){
        return $this->belongsTo("App\distract");
    }
    public function is_avialable(){
        $avialable=0;
        foreach ($this->apartments as $key => $apartment) {
            if($apartment->contract()->count() > 0){
                if(apartment::where("id" , $apartment->id)
                    ->whereRaw("id not in ( select apartment_id from contracts where active is true )")->exists()
                    ){
                        $avialable = 1;
                }
            }
            else{
                $avialable = 1;
            }
        }
        return $avialable;
    }
}
