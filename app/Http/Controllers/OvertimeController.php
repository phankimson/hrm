<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Overtime;
use App\Http\Models\Employee;
use App\Http\Models\Department;
use App\Http\Models\Period;


class OvertimeController extends Controller{
    public function showPage(){
        $department = Department::get_active();
        $period = Period::get_active();
        return view("admin.pages.Overtime",['department'=>$department,'period'=>$period]);
    }
    public function load(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);
        $value = Overtime::get_employee($d->period_id,$d->department_id);
        if($d->oper == 'add' &&$value ->count() <=0){         
          $employee = Employee::get_department($d->department_id);
          for($i =0; $i<$employee->count();$i++){
            $employee[$i]['value'] = 0;  
          };
            return response()->json( [
                'status' 	=> true,
                'data'          => $employee,
                'message' => trans('messages.success_load'),
            ]);
        }else if($d->oper == 'edit' &&$value ->count() >0 || $d->oper == 'print' &&$value ->count() >0){
          $employee = Employee::get_advance($d->department_id,$d->period_id);
          foreach($employee as $key => $val){
              if(count($val['advance'])){
              $employee[$key]['value']=$val['advance'][0]['value'];        
              }else{
              $employee[$key]['value']=0;    
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