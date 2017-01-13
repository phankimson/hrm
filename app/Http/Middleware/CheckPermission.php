<?php

namespace App\Http\Middleware;

use App\Http\Models\User;
use App\Http\Models\Permission;
use App\Classes\bitmask;
use Closure;

class CheckPermission
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
        $link = $request->path();
        session()->put('url',substr($link,3));
        $locale = session()->get('locale');   
        $manage = session()->get('manage');
        if($manage=='admin'||$manage=='manage'){
            $prefix = $locale.'/'.$manage; 
        }else{
            $prefix = $locale;
        }       
        $session =  $request->session()->has('logined');
        if($session){
        $user = User::get_user_info(session('logined'));
        $list_permission = Permission::get_permission_join_menu($user->id);
          if($link== $prefix ||$link==$prefix.'/index'||$link==$prefix.'/block'||$link==$prefix.'/lock'||$link==$prefix.'/profile'||$link==$prefix.'/error'){
             $request->path($link);   
          }else if(count($list_permission)>0){         
          foreach($list_permission as $permission){
              if($locale.'/'.$permission->link == $link){
                  $perms = new bitmask();
                  $bitmask = $permission -> permission;
                  $array = $perms->getPermissions($bitmask);
                  break;
              }else{
                  $array = null;
              }
           }
          if($array['v']==true){
             session()->put("permission",$array);
          }else{
             return redirect($prefix."/block");
            }
          }else{
             return redirect($prefix."/block");
            }
          }else{
             return redirect($prefix."/login");
          }

         return $next($request);
  }
}
