<?php
namespace App\Http\Controllers;
use App\Http\Models\Options;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   

     public function __construct()
    {
    }
    
   
    public function showIndex(){       
        return view("admin.pages.index");
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