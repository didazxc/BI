<?php

namespace Zxc\Keytask\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Config;
use Zxc\Keytask\KeyTask;
use Auth;
use Redirect;


class DemandIdentify
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
        $task_id=$request->input('id');
        if ($task_id) {
            if(KeyTask::find($task_id)->from_user_id!=$this->auth->user()->id){
				abort(503);
			}
        }
        return $next($request);
    }
}
