<?php namespace Zxc\Keysql\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class ValidateAdmin {

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
		if(!$this->auth->user()->can(config('keysql.permission_admin'))){
			abort(503);
		}
		return $next($request);
	}

}