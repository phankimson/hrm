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
      public static function countDays($year, $month, $ignore) 
{
 $count = 0;
    $counter = mktime(0, 0, 0, $month, 1, $year);
    while (date("n", $counter) == $month) {
        if (in_array(date("w", $counter), $ignore) == false) {
            $count++;
        }
        $counter = strtotime("+1 day", $counter);
    }
    return $count;
}
 public static function calculator_personal_income_tax($value,$option){
        // Tổng TN tính thuế      
        $total_taxable_income = $value['total_salary']+$value['service_charge']-$value['telephone_allowance']-$value['shift_meal_allowance']-$value['petrol_allowance']-$value['orther_allowance']-$value['nss']- $value['pht']-$value['wps']-$value['wdps']-$value['social_insurance']-$value['health_insurance']-$value['unemployment_insurance']-$value['trade_union_fund']- $value['personal_deductions']-$value['number_dependents'];
         if($total_taxable_income>0){
         $value['total_taxable_income'] = $total_taxable_income;   
         }else{
         $value['total_taxable_income'] = 0;    
         };
          // Thuế TNCN
         for($i=1;$i<8;$i++){
             $k = 'PERSONAL_INCOME_LV'.$i;
            if($total_taxable_income==0||$total_taxable_income<0){
             $value['personal_income_tax'] = 0;     
            }elseif($total_taxable_income>$option->where('code',$k)->first()->value){
            $value['personal_income_tax'] = $option->where('code',$k)->first()->value1 * $total_taxable_income - $option->where('code',$k)->first()->value2;  
              break;
            }              
         }
         return $value;
    }
}