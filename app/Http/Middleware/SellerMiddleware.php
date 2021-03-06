<?php

namespace App\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;

class SellerMiddleware
{
    protected $auth;
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if ( $this->auth->guest() ) {
            if ($request->ajax()){
                return response('Unauthorized.', 401);
               } else {
                return redirect()->guest('/login');
               }
        }elseif($this->auth->check()) {
            if($request->user()->role != '2' ) {
                return redirect('/login');
            }
        }
        return $next($request);
    }
}
