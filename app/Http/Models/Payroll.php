<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
	public $table="payroll";
        /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
        public function scopeTypeWhere($query,$column, $value)
            {
                 if($value){
                return $query->where($column,'=',$value);                 
                 }else{
                return $query->whereNotNull($column);
                 }
            }
        public function scopeTypeWhereIn($query,$column, $value)
        {
             if($value){
            return $query->whereIn($column,$value);                 
             }else{
            return $query->whereNotNull($column);
             }
        }
   public static function get_all($department=null,$period=null){
         $value = Payroll::join('employee','employee.id','=','payroll.employee_id')->join('department','department.id','=','employee.department_id')->TypeWhere('employee.department_id',$department)->Typewhere('payroll.period_id',$period)->select('payroll.id','payroll.employee_id','payroll.period_id','employee.code','employee.fullname','employee.begin_work_date','department.name as department','payroll.position','payroll.salary_probationary','payroll.salary_main','payroll.salary_insurance','payroll.wage_day_probationary as wdp','payroll.workday as wd','payroll.nightshift as ns','payroll.holiday_work as wp','payroll.holiday_work_value as wps','payroll.holiday_overtime as ph3','payroll.off_overtime as ph2','payroll.overtime as ph1','payroll.work_clear as wc','payroll.arrive_leave as al','payroll.telephone_allowance','payroll.petrol_allowance','payroll.shift_meal_allowance','payroll.orther_allowance','payroll.on_leave_pay','payroll.personal_deductions','payroll.number_dependents','payroll.advance as advanced','payroll.personal_income_tax','payroll.social_insurance','payroll.health_insurance','payroll.unemployment_insurance','payroll.trade_union_fund','payroll.service_charge')->get();
        return $value;
    }   
     public static function get_save($employee,$period){
        $value = Payroll::where('employee_id','=',$employee)->where('period_id','=',$period)->first();
        return $value;
    }
}
?>
