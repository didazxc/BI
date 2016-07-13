<?php

namespace Zxc\Keyact;

use Illuminate\Database\Eloquent\Model;
use DB;
use Mockery\Exception;
use Schema;
use Illuminate\Support\Facades\Config;

class KeyAct extends Model
{
    protected $table = 'zdm__key_act';
    
    protected $casts = [
        'goal' => 'array',
    ];
	
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('keyact.keyact_table');
    }
	
	public function user()
    {
        return $this->hasOne('App\User','id','userid');
    }
    
	public function getPatternListAttribute()
	{
		$PatternList=[
			'充值活动',
			'PK联赛',
            '主播任务',
            '年度庆典',
			'官频活动',
			'产品功能',
			'版本更新',
            'bug问题',
            '严重宕机',
			'其他',
		];
		return $PatternList;
	}
	
}