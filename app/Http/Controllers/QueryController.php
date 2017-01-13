<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
class QueryController extends Controller
{

    public function showQuery(){
        return view("admin.pages.Query");
    }
    public function querySql(Request $request){
        try {
        $data = $request->input('data');
        $t = json_decode($data);  
        $sql = $t->query;
        if(strpos($sql,'select') !== false){
         $results =  DB::select(DB::raw($sql));
        }else{
        $results = DB::statement($sql);}
        return response()->json([
                'status'  => true,
                'data'    => $results,
                'message' => trans('messages.success_update'),
            ]);   
         } catch (\Exception $e) {
              return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ]);   
         }
    }
    
}