<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;

class AuthMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
                
        if (!Auth::check()){
            return redirect()->guest('/home');
        }

        $path = $request->segment(1);

        if($path=='beranda' || $path==''){
            return $next($request);
        }


        $id_user = Auth::user()->id;
        $cek_menu = DB::select("
            select count(a.id_menu) as akses, 
            sum(b.a_create) as a_create, sum(b.a_update) as a_update ,sum(b.a_delete) as a_delete 
            from menu as a, role_menu as b, user_role as c 
            where a.id_menu=b.id_menu and b.id_role = c.id_role 
            and a.url='$path' and c.id_user='$id_user' group by a.id_menu
            ");

        if (count($cek_menu)==0){
            return redirect()->guest('/beranda');
        }else{
            $cek_menu = $cek_menu[0];
            $crud_akses = array('update'=>$cek_menu->a_update,
                            'create'=>$cek_menu->a_create,
                            'delete'=>$cek_menu->a_delete);
            Session::put('uc-'.$path,json_encode($crud_akses));
        }

        return $next($request);
    }
}
