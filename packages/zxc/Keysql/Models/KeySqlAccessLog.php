<?php
namespace Zxc\Keysql\Models;
use Illuminate\Database\Eloquent\Model;

class KeySqlAccessLog extends Model
{
    protected $table = 'zxc__key_sql_access_log';

    public $timestamps = false;
    
    protected $casts = [
        'input' => 'array',
    ];
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('keysql.accesslog_table','zxc__key_sql_access_log');
    }
    
    public function keysql(){
        return $this->belongsTo('Zxc\Keysql\Models\KeySql','sqlid','id');
    }
    
    public function keysqlnav(){
        return $this->belongsTo('Zxc\Keysql\Models\KeySqlNav','navid','id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User','username','name');
    }
    
    
}