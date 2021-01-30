<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if($role == 'teachers') {
            $id = $request->route('teacher_id');
        }else{
            $id = $request->route('id');
        }
        $user = User::find($id);
        if($user){
            if(!$user->hasRole($role)){
                session()->flash('success', __('site.wrong_url'));
                return redirect()->route('dashboard.index');
            }
        }else{
            session()->flash('success', __('site.wrong_url'));
            return redirect()->route('dashboard.index');
        }
        return $next($request);
    }
}
