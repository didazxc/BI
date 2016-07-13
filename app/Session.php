<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function getLastTimeAttribute(){
        return date('Y-m-d H:i:s',$this->last_activity);
    }
    public function getIdAttribute($id){
        return $id;
    }
    public function delete(){
        $user=$this->user;
        if($user){
            $user->remember_token='';
            $user->save();
        }
        return parent::delete();
    }
}
