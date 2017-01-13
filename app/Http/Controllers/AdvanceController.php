<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Advance;
use App\Http\Models\TimeKeeper;
use App\Http\Models\Employee;
use App\Http\Models\Department;
use App\Http\Models\Period;
use Excel;


class AdvanceController extends Controller{
    public function showPage(){
        $department = Department::get_active();
        $period = Period::get_active();
        return view("admin.pages.Advance",['department'=>$department,'period'=>$period]);
    }
    public function load(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);
        $value = Advance::get_employee($d->period_id,$d->department_id);
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
          $employee = Employee::get_advance($d->department,$d->period_id);
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
           foreach($t->input as $ts){
                if($ts->amount>0){
                   $value = Advance::get_advance_save($ts -> id, $t->date);
                        if($value !== null){
                        $return = Advance::find($value->id);
                        }else{
                        $return = new Advance(); 
                        }
                        $return->date                 = $t -> date;
                        $return->employee_id          = $ts -> id;
                        $return->advance_amount       = $ts -> amount;
                        $return->save();      
                }          
            }       
             return Response::json( array(
                'status' 	 => true,
                'message' => Lang::get('messages.success_update'),
            ));        
    }      
   
     public function deleteAdvance(){
         $company = 0;
         $date = Input::get('data');
         $check = true;
         if($check ==true){
         $id = Advance::get_advance_delete($company,$date);    
         foreach($id as $d){
             $value = Advance::find($d['id']);
             $value -> delete();
         }
             return Response::json(array(
                'status' 	 => true,
                'message' => Lang::get('messages.success_delete'),
            ));  
         }else{
             return Response::json( array(
                'status' 	 => false,
                'message' => Lang::get('messages.error_delete'),
            ));
        }            
    }  
  
}