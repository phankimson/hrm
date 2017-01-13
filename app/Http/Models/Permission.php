<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	public $table="user_permission";
        public $timestamps = false;
        public static function get_permission_with_user($user){
                $value = Permission::where('user_id','=',$user)->get();
                return $value;
        }
        public static function get_permission_join_menu($user){
                $value = Permission::where('user_id','=',$user)->join('menu','menu.id','=','user_permission.menu_id')->get();
                return $value;
        }  
}   
?>