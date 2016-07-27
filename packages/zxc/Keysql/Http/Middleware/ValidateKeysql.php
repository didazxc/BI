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
            $navs=KeySqlNav::where('sql_id',$sql_id)->get();
            foreach($navs as $nav){
                if($this->permission($nav)){
                    return $next($request);
                };
            }
            abort(503);
        }else{
            $nav_id=$request->route('nav_id');
            if($nav_id){
                $nav=KeySqlNav::find($nav_id);
                if(!$this->permission($nav)){
                    abort(503);
                }
            }
        }
		return $next($request);
	}

    public function permission($nav){
        if(!$nav){
            return false;
        }
        if($this->auth->user()->can(config('keysql.permission_admin'))){
            return true;
        }
        //直接权限判断
        if($this->auth->user()->can($nav->permission)){
            return true;
        }
        //如果是叶子节点，则权限同其父类的权限
        if($nav->_rgt-1==$nav->_lft){
            $parentnav=$nav->ancestors()->where('id','>','1')->orderBy('_rgt')->first();
            if($parentnav){
                if($this->auth->user()->can($parentnav->permission)){
                    return true;
                }
            }
        }
        return false;
    }


}
