<?php

namespace Zxc\Keytask;

use Illuminate\Database\Eloquent\Model;
use DB;
use Mockery\Exception;
use Illuminate\Support\Facades\Config;

class KeyTask extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('keytask.keytask_table');
    }

    public function join_user(){
        return $this->belongsTo('App\User','join_user_name','name');
    }

    public function from_user(){
        return $this->belongsTo('App\User','from_user_name','name');
    }

    public function to_user(){
        return $this->hasOne('App\User','name','to_user_name');
    }

    public function task_hours(){
        return $this->hasMany('Zxc\Keytask\KeyTaskHour','task_id','id');
    }

    public function setStatusAttribute($value){
        if(strlen(trim($value))==0){
            $this->attributes['status'] = 'wait';
        }else{
            $this->attributes['status'] = $value;
        }
    }
    
    public function getStatus(){
        $map_arr=[
            'wait'=>'等待中',
            'done'=>'已完成',
            'cancel'=>'已取消',
            'canceling'=>'取消中',
            'doing'=>'进行中'
        ];
        return $map_arr[$this->status];
    }

    public function getProgressAttribute(){
        if($this->status=='done'){
            return 100;
        }
        if($this->consumed==0){
            return 0;
        }
        $progress=$this->consumed/($this->consumed+$this->left)*100;
        $progress=round($progress);
        return $progress;
    }

}
