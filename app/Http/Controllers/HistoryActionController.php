<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\HistoryAction;
use App\Classes\Helpers;
use App\Http\Models\User;
use Excel;
use DB;

class HistoryActionController extends Controller
{
    private $data;
    private $column;
       public function __construct()
    {
        $this->data = HistoryAction::all();
        $column  = DB::getSchemaBuilder()->getColumnListing('history_action');
        $this->column = array_diff($column, array("id", "created_at","updated_at"));
    }

  public function showPage(){
        $user = User::get_all();
        return view("admin.pages.listHistoryAction",['data'=>$this->data,'user'=>$user]);
    }
  public function save(Request $request){
        $colum = $this->column;
        $data = $request->input('data');
        $t = json_decode($data);        
            if($t->oper=='add'||$t->oper=='copy'){
            $return = new HistoryAction();
             }else{
            $return = HistoryAction::find($t->id);
            }
            foreach($colum as $value){
                   $return->$value           = Helpers::get_not_null($t-> $value,0); 
            }            
            $return->save();
            $lst_data =  HistoryAction::get_all($return->id);            
             return response()->json( [
                'status' 	 => true,
                'data'             => $lst_data,
                'message' => trans('messages.success_update'),
            ]);
	            
    }  
        
     public function delete(Request $request){
         $id = $request->input('id');
         $check = false;
         if($check ==true){
              return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_delete'),
            ]);  
         }else{
         $result = HistoryAction::find($id);
	 $result -> delete();
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]); 
        }            
    }
    
     public function export(){   
       Excel::create('ExcelFormImport', function ($excel) {
  
        $excel->sheet('HistoryAction', function ($sheet) {

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
                $return = new HistoryAction();
                foreach($colum as $value){
                   $return->$value           = Helpers::get_not_null($sh-> $value,0); 
                }      
                $return -> save();
                $data[$count] = HistoryAction::get_all($return->id); 
                $count++; 
          }  
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
  