<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSheet extends Model
{
	public $table="timesheet";
        protected $fillable = array('id');
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
        /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
      
    public static function get_all($id=null){
        $data = TimeSheet::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_employee($period=null,$department=null){
        $data = TimeSheet::join('employee','employee.id','=','timesheet.employee_id')->TypeWhereIn('employee.department_id',$department)->TypeWhere('timesheet.period_id',$period)->get();
        return $data;
    }
       public static function get_save($employee,$day,$period){
        $value = TimeSheet::where('employee_id','=',$employee)->where('day','=',$day)->where('period_id','=',$period)->first();
        return $value;
    }
 
}