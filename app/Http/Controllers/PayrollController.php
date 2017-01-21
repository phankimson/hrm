<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Payroll;
use App\Http\Models\Employee;
use App\Http\Models\Options;
use App\Http\Models\Department;
use App\Http\Models\TimeKeeper;
use App\Http\Models\Period;


class PayrollController extends Controller{
    public function showPage(){
        $department = Department::get_active();
        $period = Period::get_active();
        return view("admin.pages.Payroll",['department'=>$department,'period'=>$period]);
    }
    public function load(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);
        $value = Payroll::get_employee($d->period_id,$d->department_id);
        $timekeeper = TimeKeeper::get_all();
        $options = Options::all();
        $arr = collect([]);
        if($d->oper == 'add' &&$value ->count() <=0){         
          $employee = Employee::get_payroll($d->department_id,$d->period_id);
          $offDay = explode(',',$options->where('code','OFF_DAY')->value);// SunDay :0 & Saturday:6
          foreach($employee as $k=>$v){
               foreach($v->timesheet as $t){
                $timekeeper_code .= $t->timekeeper_code.',';
                 }
             $timesheet= explode(',',$timekeeper_code);
              foreach($timekeeper as $tk){                
                $ts[$tk->method] += $tk->value * count(array_keys($timesheet,$tk->code)) ;
                }
            $item['code'] = $v->code;   
            $item['fullname'] = $v->fullname;  
            $item['department'] = $v->department;
            $item['position'] = $v->position;
            $item['salary_main'] = $v->salary_main ;
            $item['salary_insurance'] = $v->salary_insurance ;
            $item['allowances_accordance_salaries'] = $v->allowances_accordance_salaries ;
            $arr->push($item);
          }
            return response()->json( [
                'status' 	=> true,
                'data'          => $employee,
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