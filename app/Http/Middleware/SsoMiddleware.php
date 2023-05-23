<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SsoMiddleware {
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
    * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
    */
   public function handle($request, Closure $next) {
      $token = $request->query('token');
      if ($token) {
         $ssoEntry = DB::connection('main_mysql')->table('sso_tokens')->where('token', $token)->first();
         if ($ssoEntry) {
            // Log in the user
            Auth::loginUsingId($ssoEntry->user_id);

            // Delete the token
            DB::connection('main_mysql')->table('sso_tokens')->where('token', $token)->delete();
         }
      }
      return $next($request);
   }
}
