<?php 

namespace Zxc\Keysql\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Zxc\Keysql\Models\KeySqlNav;

class ValidateKeysql {

	protected $auth;

	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        if($request->ajax){
            $sql_id=$request->input('sql_id');
            $nav_ids=KeySqlNav::where('sql_id',$sql_id)->get();
            foreach($nav_ids as $nav_id){
                if($this->permission($nav_id)){
                    return $next($request);
                };
            }
            abort(503);
        }else{
            $nav_id=$request->route('nav_id');
            if($nav_id && !$this->permission($nav_id)){
                abort(503);
            };
        }
		return $next($request);
	}

    public function permission($nav_id){
        //直接权限判断
        if($this->auth->user()->can(config('keysql.permission_prefix').$nav_id)){
            return true;
        }
        //如果是叶子节点，则权限同其父类的权限
        $thisnav=KeySqlNav::find($nav_id);
        if($thisnav && $thisnav->_rgt-1==$thisnav->_lft){
            $parentnav=$thisnav->ancestors()->where('id','>','1')->orderBy('_rgt')->first();
            if($parentnav){
                $nav_id=$parentnav->id;
                if($this->auth->user()->can(config('keysql.permission_prefix').$nav_id)){
                    return true;
                }
            }
        }
        return false;
    }


}
