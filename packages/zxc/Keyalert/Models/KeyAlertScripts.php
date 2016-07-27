<?php

namespace Zxc\Keyalert\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class KeyAlertScripts extends Model
{
    protected $table = 'zxc__key_alert_scripts';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('keyalert.keyalert_scripts_table','zxc__key_alert_scripts');
    }

    public function user()
    {
        return $this->belongsTo('App\User','username','name');
    }
    
    public function alerts()
    {
        return $this->hasMany('Zxc\Keyalert\Models\KeyAlert','script_id','id');
    }
    
    public function save(array $options = [])
    {
        $this->username=Auth::user()->name;
        return parent::save($options);
    }
    
}
