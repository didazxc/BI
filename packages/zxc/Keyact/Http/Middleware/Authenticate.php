<?php

namespace Zxc\Keyact\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
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
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                abort(503);
            } else {
                return redirect()->guest('login');
            }
        }
        if(config('keyact.permission_keyact')){
            if(!$this->auth->user()->can(config('keyact.permission_keyact'))){
                abort(503);
            }
        }
        return $next($request);
    }
}
