<?php

namespace Zxc\Keyalert\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class KeyAlert extends Model
{
    protected $table = 'zxc__key_alert';
    public $timestamps = false;
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('keyalert.keyalert_table','zxc__key_alert');
    }

    public function script(){
        return $this->belongsTo('Zxc\Keyalert\Models\KeyAlertScripts','script_id','id');
    }
    
    public function getColorAttribute(){
        $colors=['aqua','yellow','red'];
        if($this->pro>3){
            $pro= 3;
        }elseif($this->pro<1){
            $pro= 1;
        }else{
            $pro=$this->pro;
        }
        $pro=$pro-1;
        return $colors[$pro];
    }
    
    public function getCronnameAttribute(){
        switch($this->cron){
            case 1:
                return '每天';
            case 2:
                return '每周';
            case 4:
                return '每月';
            case 8:
                return '每分钟';
            case 16:
                return '每小时';
            default:
                return '';
        }
    }
    
}
