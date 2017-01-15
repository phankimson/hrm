<?php
namespace App\Http\Controllers;
use App\Http\Models\Options;
use App\Http\Models\Employee;
use App\Http\Models\LaborContract;
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
        $contract = LaborContract::get_end(array($start,$end));
        return view("admin.pages.index",['employee'=>$employee,'contract'=>$contract]);
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