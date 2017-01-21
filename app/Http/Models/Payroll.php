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
                 $value = Payroll::join('employee','employee.id','=','payroll.employee_id')->join('department','department.id','=','employee.department_id')->TypeWhereIn('employee.department_id',$department)->Typewhere('payroll.period_id','=',$period)->select('payroll.id','payroll.period_id','payroll.employee_id','payroll.salary_and_allowance','payroll.salary_insurance','payroll.workday as wd','payroll.workday_salary as wds','payroll.nightshift as ns','payroll.nightshift_salary as nss','payroll.holiday_work as wp','payroll.holiday_work_salary as wps','payroll.holiday_overtime as ph3','payroll.off_overtime as ph2','payroll.overtime as ph1','payroll.total_overtime_salary as pht','payroll.work_clear as wc','payroll.work_clear_salary as wcs','payroll.arrive_leave as al','payroll.arrive_leave_salary as als','payroll.telephone_allowance','payroll.petrol_allowance','payroll.shift_meal_allowance','payroll.orther_allowance','payroll.on_leave_pay','payroll.personal_deductions','payroll.number_dependents','payroll.advance as advanced','payroll.personal_income_tax','payroll.social_insurance','payroll.health_insurance','payroll.unemployment_insurance','payroll.trade_union_fund','payroll.service_charge','payroll.bonus_sales','employee.code','employee.fullname','employee.position','employee.state','department.name as department','employee.begin_work_date','employee.end_probationary_coefficient','employee.probationary_coefficient','employee.state')->get();
                return $value;
            }
        public static function get_employee($period=null,$department=null){
        $data = Payroll::join('employee','employee.id','=','payroll.employee_id')->TypeWhereIn('employee.department_id',$department)->TypeWhere('payroll.period_id',$period)->get();
        return $data;
    }    
}
?>
