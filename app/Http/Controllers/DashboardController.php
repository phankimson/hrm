<?php
namespace App\Http\Controllers;
use App\Http\Models\Options;
use App\Http\Models\Employee;
use App\Http\Models\LaborContract;
use App\Http\Models\Period;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   

     public function __construct()
    {
    }
    
   
    public function showIndex(){   
        $option_dt = Options::get_code('MAX_DAY_DATATABLE');
        $start = date("m-d");
        $end = date("m-d",strtotime($option_dt->value));
        $employee = Employee::get_birthday(array($start,$end));
        $employee_probationary = Employee::get_probationary(array($start,$end));
        $contract = LaborContract::get_end(array($start,$end));
        $period = Period::get_all();
        $now = time();
        $dateinfo = getdate($now);
        $first = date('Y-m-d', mktime(0, 0, 0, $dateinfo['mon'], 1, $dateinfo['year']));//ngay dau cua thang
        $last = date('Y-m-d', mktime(0, 0, 0, $dateinfo['mon'] + 1, 1, $dateinfo['year'] )- 86400);//ngay cuoi cua thang
        if(strtotime(date('Y-m-d')) - strtotime($period->last()->end)>0){
            $return = new Period();
            $return -> code = date('m/Y');
            $return -> name = "Kỳ ".date('m/Y');
            $return -> start = $first;
            $return -> end = $last;
            $return -> lock = 1;
            $return -> active = 1;
        }
        return view("admin.pages.index",['employee'=>$employee,'contract'=>$contract,'employee_probationary'=>$employee_probationary]);
    }
    
    
   public function loadChart(Request $request){
         $start = date("m-d",strtotime($request->input('startDate')));
         $end = date("m-d",strtotime($request->input('endDate')));
        $employee = Employee::get_birthday(array($start,$end));
        $contract = LaborContract::get_end(array($start,$end));
       return response()->json( [
              'e'=>$employee,
              'c'=>$contract,
            ]);  
    }

     public function redirectAdminIndex(){
        return redirect("admin/index");
    } 
     public function redirectManageIndex(){
        return redirect("manage/index");
    } 
       public function doLogout(){
        session()->forget("logined");
        $manage = session()->get('manage');
        return redirect($manage."/login");
    }
}