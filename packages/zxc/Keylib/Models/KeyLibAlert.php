<?php

namespace Zxc\Keylib\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class KeyLibAlert extends Model
{
    protected $table = 'zxc__key_lib_alert';
    public $timestamps = false;
    
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('keylib.keylib_alert_table','zxc__key_lib_alert');
    }

    public function getColorAttribute(){
        $colors=['aqua','yellow','red'];
        return $colors[$this->pro];
    }
    
    
}
