<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class CheckAssistant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $assistant_id = $request->route('id');
        $teacher_id = $request->route('teacher_id');
        $assistant = User::find($assistant_id);
        if ($assistant->assistant_profile->teacher_id != $teacher_id){
            session()->flash('success', __('site.wrong_url'));
            return redirect()->route('dashboard.index');
        }
        return $next($request);
    }
}
