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
        return $this->hasOne('App\User','name','user_name');
    }

	public function delete(){
		parent::delete();
		$task=KeyTask::find($this->task_id);
		$task->consumed=KeyTaskHour::where('task_id',$this->task_id)->sum('consumed');
		$task->save();
	}
	
}
