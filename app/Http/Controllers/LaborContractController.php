<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\LaborContract;
use App\Http\Models\Employee;
use App\Http\Models\Template;
use App\Http\Models\Options;
use App\Classes\Helpers;
use Excel;
use DB;

class LaborContractController extends Controller
{
    private $data;
    private $column;
    public function __construct()
    {
        $this->data = LaborContract::all();
        $column  = DB::getSchemaBuilder()->getColumnListing('labor_contract');
        $this->column = array_diff($column, array("id"));
    }

    public function showPage(){
        $option = Options::get_code('TEMPLATE_CONTRACT');
        $employee = Employee::get_all();
        $print = Template::get_by_code($option->value);
        return view("admin.pages.listLaborContract",['data'=>$this->data,'employee'=>$employee,'print'=>$print]);
    }
    public function save(Request $request){
        $colum = $this->column;
        $data = $request->input('data');
        $t = json_decode($data);
        if($t->oper=='add'||$t->oper=='copy'){
            $return = new LaborContract();
        }else{
            $return = LaborContract::find($t->id);
        }
        foreach($colum as $value){
            $return->$value           = Helpers::get_not_null($t-> $value,0);
        }
        $return->save();
        $lst_data =  LaborContract::get_all($return->id);
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
            $result = LaborContract::find($id);
            Helpers::save_history_action('delete', serialize($result->toArray()));
            $result -> delete();
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]);
        }
    }

    public function export(){
        Excel::create('ExcelFormImport', function ($excel) {

            $excel->sheet('LaborContract', function ($sheet) {

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
                $return = new LaborContract();
                foreach($colum as $value){
                    $return->$value           = Helpers::get_not_null($sh-> $value,0);
                }
                $return -> save();
                $data[$count] = LaborContract::get_all($return->id);
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
       public function printData(Request $request){
        $data = $request->input('data');
        $t = json_decode($data);
        $company_name = Options::get_code('COMPANY');
        $company_director = Options::get_code('DIRECTOR_COMPANY');
        $company_country = 'Việt Nam';
        $company_phone = Options::get_code('PHONE');
        $company_address = Options::get_code('ADDRESS');
        $print = Template::get_by_code($t->key);
        $employee = Employee::get_all($t->employee_id);
        $salary_other = number_format($employee->first()->allowances_accordance_salaries+$employee->first()->telephone_allowance+$employee->first()->orther_allowance, 0, ',', '.');
        $list = array('$company.name'=>$company_name->value,
            '$company.director'=>$company_director->value,
            '$company.country'=>$company_country,
            '$company.phone'=>$company_phone->value,
            '$company.address'=>$company_address->value,
            '$labor.code'=>$t->code,
            '$day'=>date("d"),
            '$month'=>date("m"),
            '$year'=>date('Y'),
            '$employee.fullname'=>$employee->first()->fullname,
            '$employee.address'=>$employee->first()->address,
            '$employee.national'=>$employee->first()->national,
            '$employee.birthday'=> date_format(date_create($employee->first()->birthday),'d/m/Y'),
            '$employee.identity_card'=>$employee->first()->identity_card,
            '$employee.card_date'=>date_format(date_create($employee->first()->identity_card_date),'d/m/Y'),
            '$employee.card_place'=>$employee->first()->identity_card_place,
            '$employee.position'=>$employee->first()->position,
            '$employee.salary'=>number_format($employee->first()->salary_main, 0, ',', '.'),
            '$employee.orther'=>$salary_other,
            '$employee.begin'=>date_format(date_create($t->contract_date),'d/m/Y'),
            '$employee.end'=>date_format(date_create($t->contract_end),'d/m/Y'),
            );
            $newprint = strtr($print->first()->content,$list);
            return response()->json( [
                'arr'             => $newprint,
            ]);   
    }

}
  