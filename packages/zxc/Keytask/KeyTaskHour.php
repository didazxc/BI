<?php

namespace Zxc\Keytask;

use Illuminate\Database\Eloquent\Model;
use DB;
use Mockery\Exception;
use Illuminate\Support\Facades\Config;

class KeyTaskHour extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('keytask.keytaskhour_table');
    }

    public function task(){
        return $this->belongsTo('Zxc\Keytask\KeyTask','task_id','id');
    }

    public function user(){
        return $this->hasOne('App\User','id','user_id');
    }
/*
    public function setConsumedAttribute($consumed){
        if($this->task_id){
            $task=KeyTask::find($this->task_id);
            $task->consumed=KeyTaskHour::where('task_id',$this->task_id)->sum('consumed')+$consumed;
	        $task->save();
        }
        $this->attributes['consumed'] = $consumed;
    }

    public function setLeftAttribute($left){
        if($this->task_id) {
            $task = KeyTask::find($this->task_id);
            $task->left = $left;
            $task->save();
        }
        $this->attributes['left'] = $left;
    }
*/
	public function delete(){
		parent::delete();
		$task=KeyTask::find($this->task_id);
		$task->consumed=KeyTaskHour::where('task_id',$this->task_id)->sum('consumed');
		$task->save();
	}
	
}
