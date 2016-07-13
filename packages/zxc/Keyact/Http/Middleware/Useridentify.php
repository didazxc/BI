<?php

namespace Zxc\Keyact\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Config;
use Zxc\Keyact\KeyAct;
use Auth;
use Redirect;


class Useridentify
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
		//if(!$this->auth->has('admin')){}
        if ($request->input('id')) {
            if(KeyAct::find($request->input('id'))->userid!=$this->auth->user()->id){
				return Redirect::route('home');
			}
        }
        return $next($request);
    }
}
