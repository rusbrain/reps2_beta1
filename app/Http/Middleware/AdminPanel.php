<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminPanel
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
        if (Auth::user()->user_role_id == 0) {
            return redirect('/');
        }

        // Normal admins
        if (Auth::user()->user_role_id == 2) {
            //prevent admin.user.role and admin.dbbackup for Normal users
            if($request->is("admin_panel/user/role") || $request->is("admin_panel/dbbackup/*")) {
                return redirect('admin_panel/');
            }
        }

        // Morderators
        if (Auth::user()->user_role_id == 3) {
            if(!$request->is("admin_panel/forum/*") && !$request->is("admin_panel/replay/*") && !$request->is("admin_panel")) {
                return redirect('admin_panel/');
            }
        }        

        return $next($request);
    }
}
