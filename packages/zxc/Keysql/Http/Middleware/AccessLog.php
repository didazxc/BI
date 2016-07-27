<?php

namespace Zxc\Keysql\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Zxc\Keysql\Models\KeySqlAccessLog;
use Zxc\Keysql\Models\KeySqlNav;

class AccessLog
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
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
        $log=new KeySqlAccessLog();
        $log->logtime=date('Y-m-d H:i:s');
        $log->username=$this->auth->user()->name;
        $log->userid=$this->auth->user()->id;
        $log->url=$request->url();
        $input=$request->input();
        unset($input['_token']);
        $log->input=$input;
        $log->method=$request->method();
        if($request->route('nav_id')){
            $log->navid=$request->route('nav_id');
            $nav=KeySqlNav::find($log->navid);
            $log->navname=$nav->name;
            $log->sqlid=$nav->sql_id;
        }elseif($request->input('sql_id',0)){
            $log->sqlid=$input['sql_id'];
        }
        $log->save();
        return $next($request);
        
    }
}
