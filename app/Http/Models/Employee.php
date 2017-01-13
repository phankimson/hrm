<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	public $table="employee";
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
        $data = Employee::TypeWhere('id',$id)->get();
        return $data;
    }  
    public static function get_department($department=null){
        $data = Employee::TypeWhere('department_id',$department)->join('department','department.id','=','employee.department_id')->select('department.name as department','employee.*')->get();
        return $data;
    } 
     public static function get_timesheet($department=null,$period){
                $value = Employee::join('department','department.id','=','employee.department_id')->TypeWhere('employee.department_id',$department)->with(['timesheet' => function($query)use($period){$query->where('timesheet.period_id','=',$period)->get();}])->select('employee.id','employee.code','employee.fullname','employee.position','department.name as department')->orderBy('department.name')->get()->toArray();
                return $value;
            }
     public static function get_advance($department=null,$period){
                $value = Employee::join('department','department.id','=','employee.department_id')->TypeWhere('employee.department_id',$department)->with(['advance' => function($query)use($period){$query->where('advance.period_id','=',$period)->select('advance.id','advance.advance_amount','employee_id');}])->select('employee.id','employee.code','employee.fullname','employee.position','department.name as department')->orderBy('department.name')->get()->toArray();
                return $value;
            }       
     public function timesheet()
    {
        return $this->hasMany('App\Http\Models\Timesheet','employee_id');
    }       
 public function advance()
    {
        return $this->hasMany('App\Http\Models\Advance','employee_id');
    }         
}