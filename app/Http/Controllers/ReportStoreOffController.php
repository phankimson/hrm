<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Department;
use App\Http\Models\Employee;
use App\Http\Models\Period;

class ReportStoreOffController extends Controller
{


  public function showPage(){
        $date = date('m/Y');
        $employee = Employee::get_storeoff(null,null,null,null);
        $period = Period::get_active();
        $department = Department::get_active();
        $arr = collect([]);       
        foreach($employee as $p){
        $opening_stock_quantity = 0;
        $receipt_stock_quantity =0;
        $issue_stock_quantity =0;
        $closing_stock_quantity = 0;
            if($p->storeoff){
             foreach($p->storeoff as $s){ 
                 $pd = Period::get_all($s->period_id);
            if(strtotime('01/'.$date) == strtotime('01/'.$pd->first()->code) ){
                if($s->type == 1){
                $receipt_stock_quantity += $s-> value;
                }else{
                $issue_stock_quantity += $s-> value;
                }
            }else if(strtotime('01/'.$date) > strtotime('01/'.$pd->first()->code)){
                if($s->type == 1){
                $opening_stock_quantity += $s-> value;
                }else{
                $opening_stock_quantity -= $s-> value;  
                }
              }              
            }
              $closing_stock_quantity = $opening_stock_quantity + $receipt_stock_quantity - $issue_stock_quantity;
              $arr->push([
                        'id'=>$p->id,
                        'code'=>$p->code,
                        'name'=>$p->fullname,
                        'position'=>$p->position,
                        'department'=>$p->department,
                        'opening_stock_quantity'=>$opening_stock_quantity,
                        'receipt_stock_quantity'=>$receipt_stock_quantity,
                        'issue_stock_quantity'=>$issue_stock_quantity,
                        'closing_stock_quantity'=>$closing_stock_quantity,
                    ]);   
                }
        }
        return view("admin.pages.reportStoreOff",['data' => $arr,'employee'=>$employee,'period'=>$period,'department'=>$department]);
    }
    
    public function loadReport(Request $request){
        $data = $request->input('data');
        $t = json_decode($data);
        $employee = $t->employee_id;
        if($employee == ""){
           $employee = null; 
        }
        
        $period = $t->period_id;
         if($period == ""){
           $period = null; 
           $date = date('m/Y');
        }else{
           $period = null; 
           $date = Period::get_all($t->period_id)->first()->code;
        }
        $department = $t->department_id;
         if($department == ""){
           $department = null; 
        }
        $name = $t->name;
         if($name == ""){
           $name = null; 
        }
        $result = Employee::get_storeoff($department, $name, $employee, $period);
        $arr = collect([]);
        foreach($result as $p){
        $opening_stock_quantity = 0;
        $receipt_stock_quantity =0;
        $issue_stock_quantity =0;
        $closing_stock_quantity = 0;
            if($p->storeoff){
             foreach($p->storeoff as $s){ 
                 $pd = Period::get_all($s->period_id);
            if(strtotime('01/'.$date) == strtotime('01/'.$pd->first()->code) ){
                if($s->type == 1){
                $receipt_stock_quantity += $s-> value;
                }else{
                $issue_stock_quantity += $s-> value;
                }
            }else if(strtotime('01/'.$date)> strtotime('01/'.$pd->first()->code)){
                if($s->type == 1){
                $opening_stock_quantity += $s-> value;
                }else{
                $opening_stock_quantity -= $s-> value;  
                }
              }              
            }
              $closing_stock_quantity = $opening_stock_quantity + $receipt_stock_quantity - $issue_stock_quantity;
              $arr->push([
                        'id'=>$p->id,
                        'code'=>$p->code,
                        'name'=>$p->fullname,
                        'position'=>$p->position,
                        'department'=>$p->department,
                        'opening_stock_quantity'=>$opening_stock_quantity,
                        'receipt_stock_quantity'=>$receipt_stock_quantity,
                        'issue_stock_quantity'=>$issue_stock_quantity,
                        'closing_stock_quantity'=>$closing_stock_quantity,
                    ]);   
                }
        }
             return response()->json( [
                'status' 	 => true,
                'data'          => $arr,
                'message' => trans('messages.success_update'),
            ]);
	            
    }
}
  