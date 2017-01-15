<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
	public $table="overtime";
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
        $data = Overtime::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_employee($period=null,$department=null){
        $data = Overtime::join('employee','employee.id','=','overtime.employee_id')->TypeWhereIn('employee.department_id',$department)->TypeWhere('overtime.period_id',$period)->get();
        return $data;
    }
     public static function get_save($employee,$period){
        $value = Overtime::where('employee_id','=',$employee)->where('period_id','=',$period)->first();
        return $value;
    }
 
}