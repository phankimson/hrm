<?php
namespace App\Http\Controllers;

use App\Http\Models\Permission;
use App\Http\Models\User;
use App\Classes\bitmask;
use Illuminate\Http\Request;

class PermissionController extends Controller{
    public function showPermission(){
        $user = User::all();
        return view("admin.pages.permission",['user'=>$user]);
    }
      public function showBlock(){
        return view("admin.pages.block");
    }
    public function savePermission(Request $request){
        $data = $request->input('data');
        $list_perm = json_decode($data); 
        foreach($list_perm as $perm){
            if($perm ->id){
            $result = Permission::find($perm ->id);    
            }else{
            $result = new Permission;                
            }
            $result -> menu_id = $perm -> menu;
            $result -> user_id = $perm -> user;
            foreach($perm ->action as $a){
                   $array[$a->name]= $a->permission;
            }
            $perms = new bitmask();
            $perms->permissions = $array;
            $bitmask = $perms->toBitmask();
            $result -> permission = $bitmask;
            $result -> save();   

        }
         return response()->json([
                'status'  => true,
                'message' => trans('messages.success_update'),
            ]);        
    }
      public function loadPermission(Request $request){
          $user_id = $request->input('data');
          $list_permission = Permission::get_permission_with_user($user_id);
          if(count($list_permission)>0){
          foreach($list_permission as $perm){
              $perms = new bitmask();
              $bitmask = $perm -> permission;
              $array = $perms->getPermissions($bitmask);
              foreach($array as $key => $value){
                  $data[$key.'-'.$perm -> menu_id] = $value;
                  $permission[$perm -> id] = $perm -> menu_id;
              }
          }
           return response()->json([
                'status' 	 => true,
                'data'           => $data,
                'perm'           => $permission,
//                'message' => Lang::get('messages.success_update'),
            ]);    
         }else{
           return response()->json( [
                'status' 	 => true,
                'data'           => null,
                'permission'     => null,
//                'message' => Lang::get('messages.success_update'),
            ]);      
         }
      }
}