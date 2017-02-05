<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Employee;
use App\Http\Models\Options;
use App\Http\Models\Department;
use App\Http\Models\TimeKeeper;
use App\Http\Models\Period;
use App\Http\Models\Payroll;
use App\Http\Models\StoreOff;
use App\Http\Models\ChargeRevenue;
use App\Classes\Helpers;


class PayrollController extends Controller{
    public function showPage(){
        $department = Department::get_active();
        $period = Period::get_active();
        return view("admin.pages.Payroll",['department'=>$department,'period'=>$period]);
    }
    public function load(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);
        $timekeeper = TimeKeeper::get_all();
        $options = Options::all();
        $period = Period::get_all($d->period_id);
        $charge_revenue = ChargeRevenue::get_period($d->period_id);
        $arr = collect([]);
        $payroll = Payroll::get_all($d->department_id,$d->period_id);
        $offday_option = $options->where('code','OFF_DAY')->first();
        $percent_ph1 = $options->where('code','PERCENT_OVERTIME_1')->first();
        $percent_ph2 = $options->where('code','PERCENT_OVERTIME_2')->first();
        $percent_ph3 = $options->where('code','PERCENT_OVERTIME_3')->first();
        
        $hourworkday_option = $options->where('code','HOUR_WORK_DAY')->first();
         
          $percent_night_shift = $options->where('code','PERCENT_NIGHT_SHIFT')->first();
          
          $percent_social_insurance = $options->where('code','PERCENT_SOCIAL_INSUR')->first();
          $percent_health_insurance = $options->where('code','PERCENT_HEALTH_INSUR')->first();
          $percent_unemployment_insurance = $options->where('code','PERCENT_UNEMPLOYEE')->first();
          $percent_trade_union_fund =$options->where('code','PERCENT_TRADE_UNION')->first();
          
          $price_personal_deductions = $options->where('code','PRICE_PERSONAL_DEDUCT')->first();
          $price_number_dependents =  $options->where('code','PRICE_NUMBER_DEDUCT')->first(); 
          
          $calculator_personal_income_tax =  $options->where('code','CALCULATOR_PERSONAL_INCOME_TAX')->first(); 
          $calculator_insurrance =  $options->where('code','CALCULATOR_INSURRANCE')->first(); 
          
           if(strpos($offday_option->value,",")){ 
              $offDay = explode(',',$offday_option->value);          // SunDay :0 & Saturday:6            
          }else{
              $offDay[0] = $offday_option->value; // SunDay :0 & Saturday:6                      
          };
          $date = explode('/',$period->first()->code);
          $workDay = Helpers::countDays($date[1], $date[0],$offDay );
        if($d->oper == 'add' && $payroll->count()<=0){      

          $employee = Employee::get_payroll($d->department_id,$d->period_id,1);       
          foreach($employee as $k=>$v){
               $timekeeper_code = ''; $ts = [];$timekeeper_code_probationary='';$tsp = [];$total_work = 0 ;$total_probationary_work=0;
               foreach($v->timesheet as $t){
                   if(strtotime($date[1].'-'.$date[0].'-'.$t->day)-strtotime($v->end_probationary_coefficient)>0){
                     $timekeeper_code .= preg_replace('/^,/', '', $t->timekeeper_code).',';
                     $total_work ++;
                   }else{
                     $timekeeper_code_probationary .=   preg_replace('/^,/', '', $t->timekeeper_code).',';
                     $total_probationary_work ++;
                   }
                 }
             $timesheet= explode(',',$timekeeper_code);
             $timesheet_probationary = explode(',',$timekeeper_code_probationary);
              foreach($timekeeper as $tk){
                  if(isset($ts[$tk->method])){
                $ts[$tk->method] += $tk->value * count(array_keys($timesheet,$tk->code)) ;
                  }else{
                $ts[$tk->method] = 0 ;      
                $ts[$tk->method] += $tk->value * count(array_keys($timesheet,$tk->code)) ;      
                  }
                }
               foreach($timekeeper as $tkp){
                  if(isset($tsp[$tkp->method])){
                $tsp[$tkp->method] += $tkp->value * count(array_keys($timesheet_probationary,$tkp->code)) ;
                  }else{
                $tsp[$tkp->method] = 0 ;      
                $tsp[$tkp->method] += $tkp->value * count(array_keys($timesheet_probationary,$tkp->code)) ;      
                  }
                }      
             $salary_work_day = ($v->salary_main + $v->allowances_accordance_salaries) / $workDay ;  
             $salary_probationary_work_day = ($v->salary_main * $v->probationary_coefficient) / $workDay ;  
            $item['id'] = $v->id;   
            $item['code'] = $v->code;   
            $item['fullname'] = $v->fullname;  
            $item['department'] = $v->department;
            $item['position'] = $v->position;
            $item['begin_work_date'] = $v->begin_work_date ;
            $item['salary_main'] = $v->salary_main + $v->allowances_accordance_salaries;
            $item['salary_probationary'] = $v->salary_main * $v->probationary_coefficient;
            $item['salary_insurance'] = $v->salary_insurance ;
            $item['wdp'] = $tsp['1'];
            $item['wdps'] = $item['wdp'] * $salary_probationary_work_day;
            $item['wd'] = $ts['1']+$ts['5'];
            $item['wds'] = $item['wd'] * $salary_work_day;
            $item['wp'] =  ($ts['1']+$ts['3']+$ts['4']+$ts['5'] - $total_work + $ts['2'])+ ($tsp['1']+$tsp['3']+$tsp['4']+$tsp['5'] - $total_probationary_work + $tsp['2']);
            $item['wps'] = ($ts['1']+$ts['3']+$ts['4']+$ts['5'] - $total_work + $ts['2']) * $salary_work_day + ($tsp['1']+$tsp['3']+$tsp['4']+$tsp['5'] - $total_probationary_work + $tsp['2'])* $salary_probationary_work_day ;
            $item['ph1'] = 0 ; $item['ph2'] = 0; $item['ph3'] = 0;
            $item['personal_deductions'] = $v->personal_deductions * $price_personal_deductions->value;
            $item['number_dependents'] = $v->number_dependents * $price_number_dependents->value;
             foreach($v->overtime as $o){
                $item['ph1'] += $o->value/$hourworkday_option->value;
                $item['ph2'] += $o->value1/$hourworkday_option->value;
                $item['ph3'] += $o->value2/$hourworkday_option->value;
                 }
            $item['pht'] = ($item['ph1'] * $percent_ph1->value + $item['ph2'] * $percent_ph2->value + $item['ph3'] * $percent_ph3->value) * $salary_work_day;  
            $item['ns'] = $ts['5'];
            $item['nss'] = $item['ns'] * $salary_work_day * $percent_night_shift->value;
            $item['al'] = $ts['3'];
            $item['als'] = $item['al']  * $salary_work_day;
            $item['wc'] = $ts['4'];
            $item['wcs'] = $item['wc']  * $salary_work_day;
            $item['telephone_allowance'] = $v->telephone_allowance;
            $item['petrol_allowance'] = $v->petrol_allowance;
            $item['shift_meal_allowance'] = $v->shift_meal_allowance;
            $item['orther_allowance'] = $v->orther_allowance;
            $item['total_salary'] = $item['orther_allowance']+$item['telephone_allowance']+$item['petrol_allowance']+$item['shift_meal_allowance']+$item['wds'] + $item['nss'] + $item['als'] + $item['wcs'] + $item['wps']+ $item['pht']+$item['wdps'];    
            $item['advanced'] = 0;
            foreach($v->advance as $a){
                $item['advanced'] += $a->value ;
                 }
            ($charge_revenue->sum('revenue')>0) ? $item['service_charge'] = $charge_revenue->sum('revenue') / $employee->where('state',2)->count() : $item['service_charge'] = 0;          
            $item['on_leave_pay'] = 0;
          if($v->state == 0 || $v->state == 1){
            $item['total_taxable_income'] = 0; 
            $item['personal_income_tax'] = 0;  
            $item['social_insurance'] = 0;
            $item['health_insurance'] = 0;
            $item['unemployment_insurance'] = 0;
            $item['trade_union_fund'] = 0;
          }else{
             if($calculator_insurrance->value == 1){ 
            $item['social_insurance'] =  $item['salary_insurance']* $percent_social_insurance->value  ;
            $item['health_insurance'] = $item['salary_insurance']* $percent_health_insurance->value ;
            $item['unemployment_insurance'] = $item['salary_insurance']* $percent_unemployment_insurance->value;
            $item['trade_union_fund'] = $item['salary_insurance']* $percent_trade_union_fund->value;  
             }else{
            $item['social_insurance'] = 0;
            $item['health_insurance'] = 0;
            $item['unemployment_insurance'] = 0;
            $item['trade_union_fund'] = 0;     
             }
            if($calculator_personal_income_tax->value == 1){
            $item = Helpers::calculator_personal_income_tax($item, $options);  
            }else{
            $item['total_taxable_income'] = 0; 
            $item['personal_income_tax'] = 0;     
            }
          }          
            $item['total_deduction'] = $item['advanced']+$item['personal_income_tax']+$item['social_insurance']+$item['health_insurance']+$item['unemployment_insurance']+$item['trade_union_fund'];
            $item['pay_employee'] = $item['total_salary'] - $item['total_deduction'];
            $arr->push($item);
          }
            return response()->json( [
                'status' 	=> true,
                'data'          => $arr,
                'message' => trans('messages.success_load'),
            ]);
        }else if($d->oper == 'edit' && $payroll->count() >0 || $d->oper == 'print' && $payroll->count() > 0){        
            foreach($payroll as $v){
                 $salary_work_day = $v->salary_main / $workDay ;  
                 $salary_probationary_work_day = $v->salary_probationary / $workDay ;
                 $item['id'] = $v->employee_id; 
                 $item['code'] = $v->code;   
                 $item['fullname'] = $v->fullname;  
                 $item['department'] = $v->department;
                 $item['position'] = $v->position;
                 $item['begin_work_date'] = $v->begin_work_date ;
                 $item['salary_main'] = $v->salary_main ;
                 $item['salary_probationary'] = $v->salary_probationary;
                 $item['salary_insurance'] = $v->salary_insurance ;
                 $item['wdp'] = $v->wdp;
                $item['wdps'] = $v->wdp * $salary_probationary_work_day;
                $item['wd'] = $v->wd;
                $item['wds'] = $v->wd * $salary_work_day;
                $item['wp'] =  $v->wp;
                $item['wps'] = $v->wps ;
                $item['ph1'] = $v->ph1 ; 
                $item['ph2'] = $v->ph2;
                $item['ph3'] = $v->ph3;
                $item['pht'] = ($item['ph1'] * $percent_ph1->value + $item['ph2'] * $percent_ph2->value + $item['ph3'] * $percent_ph3->value) * $salary_work_day;  
                $item['ns'] = $v->ns;
                $item['nss'] = $v->ns * $salary_work_day * $percent_night_shift->value;
                $item['al'] = $v->al;
                $item['als'] = $item['al']  * $salary_work_day;
                $item['wc'] = $v->wc;
                $item['wcs'] = $item['wc']  * $salary_work_day;
                $item['telephone_allowance'] = $v->telephone_allowance;
                $item['petrol_allowance'] = $v->petrol_allowance;
                $item['shift_meal_allowance'] = $v->shift_meal_allowance;
                $item['orther_allowance'] = $v->orther_allowance;
                $item['total_salary'] = $item['orther_allowance']+$item['telephone_allowance']+$item['petrol_allowance']+$item['shift_meal_allowance']+$item['wds'] + $item['nss'] + $item['als'] + $item['wcs'] + $item['wps']+ $item['pht']+$item['wdps'];    
                $item['advanced'] = $v->advance;
                $item['service_charge'] = $v->service_charge;
                $item['on_leave_pay'] = $v->on_leave_pay;
                $item['personal_deductions'] = $v->personal_deductions ;
                $item['number_dependents'] = $v->number_dependents ;
                $item['total_taxable_income'] = $v->total_taxable_income; 
                $item['personal_income_tax'] = $v->personal_income_tax;  
                $item['social_insurance'] = $v->social_insurance;
                $item['health_insurance'] = $v->health_insurance;
                $item['unemployment_insurance'] = $v->unemployment_insurance;
                $item['trade_union_fund'] = $v->trade_union_fund;
                $item['total_deduction'] = $item['advanced']+$item['personal_income_tax']+$item['social_insurance']+$item['health_insurance']+$item['unemployment_insurance']+$item['trade_union_fund'];
                $item['pay_employee'] = $item['total_salary'] - $item['total_deduction'];
                 $arr->push($item);
            }
             return response()->json( [
                'status' 	=> true,
                'data'          => $arr,
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
        
        $options = Options::all();
        $day_clear_off = $options->where('code','DAY_CLEAR_OFF')->first(); 
        $check_store_off = $options->where('code','CHECK_STORE_OFF')->first(); 
        $min_add_al = $options->where('code','MIN_ADD_AL')->first();   
        
           foreach($t->hot as $ts){
                if($ts->salary_main>0){
                   $value = Payroll::get_save($ts -> id, $t->period_id);
                        if($value !== null){
                        $return = Payroll::find($value->id);
                        }else{
                        $return = new Payroll(); 
                        }
                        $return->period_id            = $t -> period_id;
                        $return->employee_id          = $ts -> id;
                        $return->position             = $ts -> position;
                        $return->salary_main          = $ts -> salary_main;
                        $return->salary_probationary  = $ts -> salary_probationary;
                        $return->salary_insurance     = $ts -> salary_insurance;
                        $return->wage_day_probationary= $ts -> wdp;
                        $return->workday              = $ts -> wd;
                        $return->holiday_work         = $ts -> wp;
                        $return->holiday_work_value   = $ts -> wps;
                        $return->nightshift           = $ts -> ns;
                        $return->holiday_overtime     = $ts -> ph3;
                        $return->off_overtime         = $ts -> ph2;
                        $return->overtime             = $ts -> ph1;
                        $return->arrive_leave         = $ts -> al;
                        $return->work_clear           = $ts -> wc;
                        $return->on_leave_pay         = $ts -> on_leave_pay;
                        $return->telephone_allowance  = $ts -> telephone_allowance;
                        $return->petrol_allowance       = $ts -> petrol_allowance;
                        $return->shift_meal_allowance  = $ts -> shift_meal_allowance;
                        $return->orther_allowance      = $ts -> orther_allowance;
                        $return->personal_deductions   = $ts -> personal_deductions;
                        $return->number_dependents     = $ts -> number_dependents;
                        $return->advance               = $ts -> advanced;
                        $return->total_taxable_income   = $ts -> total_taxable_income;
                        $return->personal_income_tax   = $ts -> personal_income_tax;
                        $return->social_insurance   = $ts -> social_insurance;
                        $return->health_insurance   = $ts -> health_insurance;
                        $return->unemployment_insurance   = $ts -> unemployment_insurance;
                        $return->trade_union_fund   = $ts -> trade_union_fund;
                        $return->service_charge   = $ts -> service_charge;
                        $return->save();    
                        
                        if($ts -> wd + $ts -> al + $ts -> wc >= $min_add_al->value){
                        $store_off = new StoreOff();
                        $store_off -> period_id = $t -> period_id;
                        $store_off -> employee_id = $ts -> id;
                        $store_off -> name = 1 ;
                        $store_off -> type = 1 ;
                        $store_off -> value = 1 ;
                        $store_off -> active = 1 ;
                        $store_off -> save();
                        }
                        if($ts -> al>0){
                        $store_off = new StoreOff();
                        $store_off -> period_id = $t -> period_id;
                        $store_off -> employee_id = $ts -> id;
                        $store_off -> name = 1 ;
                        $store_off -> type = 2 ;
                        $store_off -> value = $ts -> al ;
                        $store_off -> active = 1 ;
                        $store_off -> save();    
                        }

                        if($ts -> wc>0){
                        $store_off = new StoreOff();
                        $store_off -> period_id = $t -> period_id;
                        $store_off -> employee_id = $ts -> id;
                        $store_off -> name = 2 ;
                        $store_off -> type = 2 ;
                        $store_off -> value = $ts -> wc ;
                        $store_off -> active = 1 ;
                        $store_off -> save();    
                        }

                        if($ts -> wp>0){
                        $store_off = new StoreOff();
                        $store_off -> period_id = $t -> period_id;
                        $store_off -> employee_id = $ts -> id;
                        $store_off -> name = 2 ;
                        $store_off -> type = 1 ;
                        $store_off -> value = $ts -> wp * $day_clear_off->value;
                        $store_off -> active = 1 ;
                        $store_off -> save();      
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
         $check = true;
         if($check ==true){
        $payroll = Payroll::get_all($t->department_id,$t->period_id);
         foreach($payroll as $d){
            $result = Payroll::find($d->id);
            $result -> delete();
            Helpers::save_history_action('delete', serialize($result->toArray()));
         }
         $storeoff = StoreOff::get_period($t->period_id);
         foreach($storeoff as $s){
            $result = StoreOff::find($s->id);
            $result -> delete();
            Helpers::save_history_action('delete', serialize($result->toArray())); 
         }
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]);  
         }else{
            return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_delete'),
            ]);
        }            
    }  
  
}