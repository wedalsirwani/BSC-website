<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\loan;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function bank()
    {
        return $this->belongsToMany('App\bank', 'users_banks');
    }
    public function role()
    {
        return $this->belongsToMany('App\role', 'users_roles');
    }
    public function account(){
        return $this->hasOne("App\account");
    }
    public function renter(){
        return $this->hasOne('App\renter');
    }
    public function hasAnyRole($roles){
        if(is_array($roles)){
            foreach($roles as $role)
            {
                if($this->hasRole($role))
                {
                    return true;
                }
            }
        }
        else{
            if($this->hasRole($roles))
            {
                return true;
            }
        }
    }
    public function hasRole($role)
    {
        if($this->role()->where('name',$role)->first())
        {
            return true;
        }
        return false;
    }
    public function count_sponsor_orders(){
        return loan::where("sponsor_id",Auth()->User()->id)->where("sponsor_approved",null)->get()->count();
    }
}
