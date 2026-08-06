<?php

namespace App\Http\Middleware;

use App\Models\Rig;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check()){
            if(auth()->user()->subscription != 'free' && auth()->user()->subscription_expiration < now()){
                auth()->user()->subscription = 'free';
                auth()->user()->subscription_expiration = null;
                auth()->user()->save();

                Rig::where('user_id',auth()->id())->update(['enable' => false]);
            }
        }
        else abort(403);
        return $next($request);
    }
}
