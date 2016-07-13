<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Auth;

class User extends Authenticatable
{
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function setPasswordAttribute($value)
    {
        if(Auth::check()){
            $this->attributes['password'] = strlen($value)>=6?bcrypt($value):$value;
        }else{
            $this->attributes['password']=$value;
        }
    }
    
    public function getIsAdminAttribute()
    {
        return true;
    }
    
}
