<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\TimeSheet;
use App\Http\Models\TimeKeeper;
use App\Http\Models\Employee;
use App\Http\Models\Department;
use App\Http\Models\Period;
use App\Classes\Helpers;
use Excel;

class TimeSheetHourController extends Controller
{

  public function showPage(){
         $department = Department::get_active();
         $period = Period::get_active();
        return view("admin.pages.TimeSheetHour",['department'=>$department,'period'=>$period]);
    }
 public function load(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);
        $value = TimeSheet::get_employee($d->period_id,$d->department_id);
         $timekeeper = TimeKeeper::get_active(null,2);
         $arr = collect([]);
         foreach($timekeeper as $t){
             $item['id'] = $t->code;
             $item['text'] = $t->name;
             $arr ->push($item); 
         }
          $period = Period::get_all($d->period_id);
        if($d->oper == 'add' &&$value ->count() <=0){         
          $employee = Employee::get_department($d->department_id);
          $emp = collect([]); $item=[];
           foreach($employee as $t){
             $item['id'] = $t->id;
             $item['code'] = $t->code;
             $item['fullname'] = $t->fullname;
             $item['position'] = $t->position;
             $item['department'] = $t->department;
             $emp ->push($item); 
         }
         
          return response()->json( [
                'status' 	=> true,
                'data'          => $emp,
                'tk'            => $arr,
                'pd'            => $period->first()->code,
                'message' => trans('messages.success_load'),
            ]);
        }else if($d->oper == 'edit' &&$value->count() > 0){
          $timesheet = Employee::get_timesheet($d->department_id,$d->period_id,2);
          for($i =0; $i<count($timesheet);$i++){
              foreach($timesheet[$i]['timesheet'] as $t){              
                $timesheet[$i][$t['day']] = $t['timekeeper_code'];  
              }
                unset($timesheet[$i]['timesheet']);
          }
          return response()->json( [
                'status' 	=> true,
                'data'          => $timesheet,
                'tk'            => $arr,
                'pd'            => $period->first()->code,
                'message' => trans('messages.success_load'),
           ]);
        }else if($d->oper == 'print' &&$value->count() > 0){
            $timesheet = Employee::get_timesheet($d->department_id,$d->period_id,2);
          for($i =0; $i<count($timesheet);$i++){
               foreach($timesheet[$i]['timesheet'] as $t){              
                $timesheet[$i][$t['day']] = $t['timekeeper_code'];  
              }
                unset($timesheet[$i]['timesheet'],$timesheet[$i]['department'],$timesheet[$i]['position']);
          }
          return response()->json( [
                'status' 	=> true,
                'data'          => $timesheet,
                'pd'            => $period->first()->code,
                'message' => trans('messages.success_load'),
              ]); 
        }else if($d->oper == 'total' &&$value->count() > 0){
          $timesheet = Employee::get_timesheet($d->department_id,$d->period_id,2);
          for($i =0; $i<count($timesheet);$i++){ 
              $timesheet[$i]['timekeeper'] ='';
              if($timesheet[$i]['timesheet']){
               foreach($timesheet[$i]['timesheet'] as $t){              
                $timesheet[$i]['timekeeper'] .= $t['timekeeper_code'].',';
               }
               $timesheet[$i]['timekeeper']= explode(',',$timesheet[$i]['timekeeper']);
                foreach($timekeeper as $tk){           
                $timesheet[$i][$tk['code']] = count(array_keys($timesheet[$i]['timekeeper'],$tk['code']));
                }
              }else{
                foreach($timekeeper as $tk){           
                $timesheet[$i][$tk['code']] = 0;
                }  
              }               
             
                unset($timesheet[$i]['timesheet'],$timesheet[$i]['department'],$timesheet[$i]['timekeeper'],$timesheet[$i]['position']);
          }
           return response()->json( [
                'status' 	=> true,
                'data'          => $timesheet,
                'tk'            => $timekeeper,
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
//        $default_column = 5;
        $data = $request->input('data');
        $t = json_decode($data);
           foreach($t->hot as $ts){ 
                foreach($ts as $key => $s){
                  if(is_numeric($key)){
                         $value = TimeSheet::get_save($ts -> id, $key,$t->period_id);
                         if($value){
                          $timesheet = TimeSheet::find($value->id);    
                         }else{
                          $timesheet = new TimeSheet();    
                         }                        
                        $timesheet->period_id            = $t->period_id;
                        $timesheet->day                  = $key;
                        $timesheet->employee_id          = $ts -> id;
                        $timesheet->timekeeper_code      = $s;
                        $timesheet->save();   
                     }   
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
         $check = false;
         if($check ==true){
              return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_delete'),
            ]);  
         }else{
        $id = TimeSheet::get_employee($t->period_id);    
         foreach($id as $d){
             $result = TimeSheet::find($d->id);
             $result -> delete();
             Helpers::save_history_action('delete', serialize($result->toArray()));
         }
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]); 
        }            
    }
    
     public function export(){   
       Excel::create('ExcelFormImport', function ($excel) {
  
        $excel->sheet('TimeKeeper', function ($sheet) {

            // getting data to display - in my case only one record
            $table = $this->column;

            // setting column names for data - you can of course set it manually
            $sheet->appendRow($table); // column names

            // getting last row number (the one we already filled and setting it to bold
//            $sheet->row($sheet->getHighestRow(), function ($row) {
             $sheet->row(1 , function ($row) {
                $row->setFontWeight('bold');
                $row->setBackground('#DCDCDC');
                $row->setFontColor('#FFA500');
            });

            // putting users data as next rows
//            foreach ($table as $t) {
//                $sheet->appendRow($t);
//            }
        });

    })->download('xls');
    }
    
    public function import(Request $request){
          $colum = $this->column;
          $file = $request->file('file');
          $filename = explode('.', $file->getClientOriginalName()) ;        
          if($filename[1]=='xls'||$filename[1]=='csv'||$filename[1]=='xlsx'){
          $sheet = Excel::load($file, function($reader) {})->get(); 
          $count = 0;
          foreach($sheet as $sh){  
                $return = new TimeKeeper();
                foreach($colum as $value){
                   $return->$value           = Helpers::get_not_null($sh-> $value,0); 
                }      
                $return -> save();
                $data[$count] = TimeKeeper::get_all($return->id); 
                $content[$count] = $data[$count]->toArray();
                $count++; 
          }  
          Helpers::save_history_action('import', serialize($content));
           return response()->json( [
                'status' 	 => true,
                'data'           => $data,
                'message' => trans('messages.success_import').' - '.$count.' '.trans('global.row'),
            ]);
          }else{
           return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_import'),
              ]);
          }
    }     
    
}
  