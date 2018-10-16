<?php

namespace App\Http\Middleware;

use App\Models\Apikey;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckBind
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::id();
        $data = Apikey::where('user_id',$user_id)->count();
        if($data <= 0) {
            return redirect('user/profile')->with('tips','请先绑定API key和secret');
        }
        return $next($request);
    }
    public function terminate($request, $response)
    {
        // Store the session data...
        $request->session()->flash('show_tips','123');
    }
}
