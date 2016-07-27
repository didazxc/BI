<?php
namespace Zxc\Keysql\Models;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class KeySqlNav extends Model
{
    use NodeTrait;
    protected $table = 'zxc__key_sql_nav';
    protected $primaryKey = 'id';

    protected $fillable=['name','desc','fa_icon'];
  
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('keysql.keysqlnav_table','zxc__key_sql_nav');
    }
    
    public function keysql(){
        return $this->belongsTo('Zxc\Keysql\Models\KeySql','sql_id','id');
    }
    
    public function user()
    {
        return $this->belongsTo('App\User','username','name');
    }

    public function getHrefAttribute($href){
        if($this->sql_id){
            
            return route('getKeysql',['nav_id'=>$this->id]);
        }
        return $href;
    }

    public function getPermissionAttribute($value){
        if(strlen($value)){
            return $value;
        }else{
            return config('keysql.permission_prefix','keysql/').$this->id;
        }
    }
    
}