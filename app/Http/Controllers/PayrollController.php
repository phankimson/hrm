<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Payroll;
use App\Http\Models\Employee;
use App\Http\Models\Options;
use App\Http\Models\Department;
use App\Http\Models\TimeKeeper;
use App\Http\Models\Period;
use App\Classes\Helpers;


class PayrollController extends Controller{
    public function showPage(){
        $department = Department::get_active();
        $period = Period::get_active();
        return view("admin.pages.Payroll",['department'=>$department,'period'=>$period]);
    }
    public function load(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);
        $timekeeper = TimeKeeper::get_all();
        $options = Options::all();
        $period = Period::get_all($d->period_id);
        $arr = collect([]);
        if($d->oper == 'add'){      
          $offday_option = $options->where('code','OFF_DAY')->first();
          $hourworkday_option = $options->where('code','HOUR_WORK_DAY')->first();
          $percent_ph1 = $options->where('code','PERCENT_OVERTIME_1')->first();
          $percent_ph2 = $options->where('code','PERCENT_OVERTIME_2')->first();
          $percent_ph3 = $options->where('code','PERCENT_OVERTIME_3')->first();
          $percent_night_shift = $options->where('code','PERCENT_NIGHT_SHIFT')->first();
          
          $percent_social_insurance = $options->where('code','PERCENT_SOCIAL_INSUR')->first();
          $percent_health_insurance = $options->where('code','PERCENT_HEALTH_INSUR')->first();
          $percent_unemployment_insurance = $options->where('code','PERCENT_UNEMPLOYEE')->first();
          $percent_trade_union_fund =$options->where('code','PERCENT_TRADE_UNION')->first();
          
          $employee = Employee::get_payroll($d->department_id,$d->period_id);
          if(strpos($offday_option->value,",")){ 
              $offDay = explode(',',$offday_option->value);          // SunDay :0 & Saturday:6            
          }else{
              $offDay[0] = $offday_option->value; // SunDay :0 & Saturday:6                      
          };
          $date = explode('/',$period->first()->code);
          $workDay = Helpers::countDays($date[1], $date[0],$offDay );
          foreach($employee as $k=>$v){
               $timekeeper_code = ''; $ts = [];
               foreach($v->timesheet as $t){
                $timekeeper_code .= str_replace(",","",$t->timekeeper_code).',';
                 }
             $timesheet= explode(',',$timekeeper_code);
              foreach($timekeeper as $tk){
                  if(isset($ts[$tk->method])){
                $ts[$tk->method] += $tk->value * count(array_keys($timesheet,$tk->code)) ;
                  }else{
                $ts[$tk->method] = 0 ;      
                $ts[$tk->method] += $tk->value * count(array_keys($timesheet,$tk->code)) ;      
                  }
                }               
             $salary_work_day = ($v->salary_main + $v->allowances_accordance_salaries) / $workDay ;  
             $total_work = count($timesheet) - 1;
            $item['code'] = $v->code;   
            $item['fullname'] = $v->fullname;  
            $item['department'] = $v->department;
            $item['position'] = $v->position;
            $item['begin_work_date'] = $v->begin_work_date ;
            $item['salary_main'] = $v->salary_main ;
            $item['salary_insurance'] = $v->salary_insurance ;
            $item['allowances_accordance_salaries'] = $v->allowances_accordance_salaries ;
            $item['wd'] = $ts['1']+$ts['5'];
            $item['wds'] = $item['wd'] * $salary_work_day;
            $item['wp'] =  $ts['1']+$ts['3']+$ts['4']+$ts['5'] - $total_work + $ts['2'];
            $item['wps'] = $item['wp'] * $salary_work_day;
            $item['ph1'] = 0 ; $item['ph2'] = 0; $item['ph3'] = 0;
             foreach($v->overtime as $o){
                $item['ph1'] += $o->value/$hourworkday_option->value;
                $item['ph2'] += $o->value1/$hourworkday_option->value;
                $item['ph3'] += $o->value2/$hourworkday_option->value;
                 }
            $item['pht'] = ($item['ph1'] * $percent_ph1->value + $item['ph2'] * $percent_ph2->value + $item['ph3'] * $percent_ph3->value) * $salary_work_day;  
            $item['ns'] = $ts['5'];
            $item['nss'] = $item['ns'] * $salary_work_day * $percent_night_shift->value;
            $item['al'] = $ts['3'];
            $item['als'] = $item['al']  * $salary_work_day;
            $item['wc'] = $ts['4'];
            $item['wcs'] = $item['wc']  * $salary_work_day;
            $item['telephone_allowance'] = $v->telephone_allowance;
            $item['petrol_allowance'] = $v->petrol_allowance;
            $item['shift_meal_allowance'] = $v->shift_meal_allowance;
            $item['orther_allowance'] = $v->orther_allowance;
            $item['total_salary'] = $item['orther_allowance']+$item['telephone_allowance']+$item['petrol_allowance']+$item['shift_meal_allowance']+$item['wds'] + $item['nss'] + $item['als'] + $item['wcs'] + $item['wps']+ $item['pht'];    
            $item['advanced'] = 0;
            foreach($v->advance as $a){
                $item['advanced'] += $a->value ;
                 }
            $item['service_charge'] = 0;
            $item['social_insurance'] =  $item['salary_insurance']* $percent_social_insurance->value * ($ts['1']+$ts['3']+$ts['4']+$ts['5']) / $workDay ;
            $item['health_insurance'] = $item['salary_insurance']* $percent_health_insurance->value * ($ts['1']+$ts['3']+$ts['4']+$ts['5']) / $workDay;
            $item['unemployment_insurance'] = $item['salary_insurance']* $percent_unemployment_insurance->value * ($ts['1']+$ts['3']+$ts['4']+$ts['5']) / $workDay;
            $item['trade_union_fund'] = $item['salary_insurance']* $percent_trade_union_fund->value * ($ts['1']+$ts['3']+$ts['4']+$ts['5']) / $workDay;   
            $arr->push($item);
          }
            return response()->json( [
                'status' 	=> true,
                'data'          => $arr,
                'message' => trans('messages.success_load'),
            ]);
        }else if($d->oper == 'edit' &&$value ->count() >0 || $d->oper == 'print' &&$value ->count() >0){
          $employee = Employee::get_overtime($d->department_id,$d->period_id);
          foreach($employee as $key => $val){
              if(count($val['overtime'])){
              $employee[$key]['value']=$val['overtime'][0]['value'];   
              $employee[$key]['value1']=$val['overtime'][0]['value1']; 
              $employee[$key]['value2']=$val['overtime'][0]['value2']; 
              }else{
              $employee[$key]['value']=0;    
              $employee[$key]['value1']=0;  
              $employee[$key]['value2']=0;  
              }           
          }
             return response()->json( [
                'status' 	=> true,
                'data'          => $employee,
                'message' => trans('messages.success_load'),
            ]);
        }else{
            return response()->json( [
                'status' 	=> false,
                'message' => trans('messages.error_load'), 
               ]);
        }
    }
    public function save(Request $request){
        $data = $request->input('data');
        $t = json_decode($data);  
           foreach($t->hot as $ts){
                if($ts->value>0){
                   $value = Overtime::get_save($ts -> id, $t->period_id);
                        if($value !== null){
                        $return = Overtime::find($value->id);
                        }else{
                        $return = new Overtime(); 
                        }
                        $return->period_id            = $t -> period_id;
                        $return->employee_id          = $ts -> id;
                        $return->value                = $ts -> value;
                        $return->value1                = $ts -> value1;
                        $return->value2                = $ts -> value2;
                        $return->save();      
                }          
            }       
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_update'),
            ]);        
    }      
   
      public function delete(Request $request){
        $data = $request->input('data');
        $t = json_decode($data);
         $check = true;
         if($check ==true){
         $id = Overtime::get_employee($t->period_id);    
         foreach($id as $d){
            $result = Overtime::find($d->id);
            $result -> delete();
            Helpers::save_history_action('delete', serialize($result->toArray()));
         }
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]);  
         }else{
            return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_delete'),
            ]);
        }            
    }  
  
}