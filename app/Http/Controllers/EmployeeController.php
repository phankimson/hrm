<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Employee;
use App\Http\Models\Department;
use App\Http\Models\Options;
use App\Classes\Helpers;
use Excel;
use DB;
use File;
use Validator;

class EmployeeController extends Controller
{
    private $data;
    private $column;
       public function __construct()
    {
        $this->data = Employee::get_all();
        $column  = DB::getSchemaBuilder()->getColumnListing('employee');
        $this->column = array_diff($column, array("id", "created_at","updated_at"));
    }

  public function showPage(){
        $department = Department::get_active();
        return view("admin.pages.listEmployee",['data'=>$this->data,'department'=>$department]);
    }
  public function save(Request $request){
        $colum = $this->column;
        $path_upload = Options::get_code('PATH_UPLOAD_PRODUCT');
        $data = $request->input('data');
        $file = $request->file('image');
        $t = json_decode($data);        
        if($file){
        $input = array('image' => $file);
		$rules = array(
			'image' => 'image|max:3000'
		);
         $validator = Validator::make($input, $rules);      
         if ( $validator->fails() )
		{        
			return response()->json(['success' => false,'message' => trans('messages.error_change_avatar'), 'errors' => $validator->getMessageBag()->toArray()]);
		}
		else {
			$destinationPath = $path_upload->value;
                        $ext             = $file->guessClientExtension();         
                        $hashname        = str_random(20).'.'.$ext;
			$pathsave        = $destinationPath.$hashname;	
		}       
        }
            if($t->oper=='add'||$t->oper=='copy'){
            $return = new Employee();
            if(!$file){
                $pathsave  = Options::get_code('IMG_UPLOAD_DEFAULT')->value;
                }
             }else{
            $return = Employee::find($t->id);
                if($file){
                    if($return->image != Options::get_code('IMG_UPLOAD_DEFAULT')->value){
                        File::Delete($return->image);
                    }
                }else{
                $pathsave  = $return->image;   
                }
            }                
            foreach($colum as $value){
                if($value == 'image'){
                   $return->$value           = $pathsave;
                }else{
                    $return->$value           = Helpers::get_not_null($t-> $value,3);   
                }                  
            }            
            $return->save();
            $arr['employee_id'] = $return->id;
            $arr['salary_main'] = $return->salary_main;
            $arr['salary_insurance'] = $return->salary_insurance;
            $arr['allowances_accordance_salaries'] = $return->allowances_accordance_salaries;
            $arr['telephone_allowance'] = $return->telephone_allowance;
            $arr['petrol_allowance'] = $return->petrol_allowance;
            $arr['shift_meal_allowance'] = $return->shift_meal_allowance;
            $arr['orther_allowance'] = $return->orther_allowance;
            Helpers::save_history_salary($arr);
                if($file){
                $file->move($destinationPath,$hashname);
                }
            $lst_data =  Employee::get_all($return->id);     
            Helpers::save_history_action($t->oper, serialize($lst_data->toArray()));
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
         $result = Employee::find($id);
         Helpers::save_history_action('delete', serialize($result->toArray()));
         if($result->image != Options::get_code('IMG_UPLOAD_DEFAULT')->value){
              File::Delete($result->image);
         }
	 $result -> delete();
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]); 
        }            
    }
    
     public function export(){   
       Excel::create('ExcelFormImport', function ($excel) {
  
        $excel->sheet('Employee', function ($sheet) {

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
           try {
            foreach($sheet as $sh){  
            $return = new Employee();
            foreach($colum as $value){
                if($value == 'image'){
                $return->$value           = Options::get_code('IMG_UPLOAD_DEFAULT')->value;  
                }else{
                $return->$value           = Helpers::get_not_null($sh-> $value,0); 
                }
            }      
            $return -> save();
            Helpers::save_history_price(1, $return->id, $return->price);
            Helpers::save_history_price(2, $return->id, $return->purchase_price);
            $data[$count] = Employee::get_all($return->id);  
            $content[$count] = $data[$count]->toArray();
            $count++; 
          }  
           Helpers::save_history_action('import', serialize($content));
           return response()->json( [
                'status' 	 => true,
                'data'           => $data,
                'message' => trans('messages.success_import').' - '.$count.' '.trans('global.row'),
            ]);
            } catch (\Exception $e) {
              return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_import'),
              ]);
            }     
          }else{
           return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_import'),
              ]);
          }
    }
    
}
  