<?php namespace App\Classes;
use App\Http\Models\HistoryAction;
use App\Http\Models\HistorySalary;
use App\Http\Models\User;
use App\Http\Models\Menu;

class Helpers {   
    public static function get_not_null($value,$type){
        if($type==0){//text
           $result = $value !=""? $value :" ";
        }elseif($type==1){
           $result = $value !=""? $value : 0; 
        }elseif($type==2){
           $result = $value !=""? $value : 0000-00-00; 
        }else{
           $result = $value !=""? $value : null; 
        }
        return $result;
    }
    public static function save_history_action($type,$content){
         switch ($type) {
            case 'login':
                    $type_id = 1;
                    break;
                
            case 'add':
                    $type_id = 2;
                    break;

            case 'copy':
                    $type_id = 3;
                    break;

            case 'edit':
                    $type_id = 4;
                    break;

            case 'delete':
                    $type_id = 5;
                    break;
            case 'import':
                    $type_id = 6;
                    break;
            default:
		$type_id = 0;
		break;   
    }
         $username = session()->get('logined');
         $user = User::get_user_info($username);
         $name = Menu::get_link(session()->get('url'));
         $return = new HistoryAction();
         $return -> user_id = $user->id;
         $return -> type = $type_id;
         $return -> menu_id = $name->id;
         $return -> content = $content;
         $return -> save();
    }
    public static function save_history_salary ($value){
        $check = HistorySalary::get_employee_last($value['employee_id']);
        if($check == null || $check->salary_main != $value['salary_main']){
        $return = new HistorySalary();
        foreach($value as $k=>$v){
            $return -> $k = $v;          
        }
             $return -> save();      
        }
    }
}