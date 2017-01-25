<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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
         public function scopeTypeWhereBetween($query,$column, $array)
        {
             if($array){
            return $query->whereBetween($column,$array);                 
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
                $value = Employee::join('department','department.id','=','employee.department_id')->TypeWhere('employee.department_id',$department)->with(['advance' => function($query)use($period){$query->where('advance.period_id','=',$period)->select('advance.id','advance.value','employee_id');}])->select('employee.id','employee.code','employee.fullname','employee.position','department.name as department')->orderBy('department.name')->get()->toArray();
                return $value;
            }   
       public static function get_overtime($department=null,$period){
                $value = Employee::join('department','department.id','=','employee.department_id')->TypeWhere('employee.department_id',$department)->with(['overtime' => function($query)use($period){$query->where('overtime.period_id','=',$period)->select('overtime.id','overtime.value','overtime.value1','overtime.value2','employee_id');}])->select('employee.id','employee.code','employee.fullname','employee.position','department.name as department')->orderBy('department.name')->get()->toArray();
                return $value;
            }    
        public static function get_payroll($department=null,$period){
                $value = Employee::join('department','department.id','=','employee.department_id')->TypeWhere('employee.department_id',$department)->with(['advance' => function($query)use($period){$query->where('advance.period_id','=',$period)->select('advance.id','advance.value','employee_id');}])->with(['timesheet' => function($query)use($period){$query->where('timesheet.period_id','=',$period)->get();}])->with(['overtime' => function($query)use($period){$query->where('overtime.period_id','=',$period)->select('overtime.id','overtime.value','overtime.value1','overtime.value2','employee_id');}])->select('employee.*','department.name as department')->orderBy('department.name')->get();
                return $value;
            }            
     public static function get_birthday($arr = null){
           $data = Employee::TypeWhereBetween(DB::raw('DATE_FORMAT(birthday, "%m-%d")'),$arr)->get();
        return $data;
     }
     public static function get_probationary($arr = null){
           $data = Employee::TypeWhereBetween(DB::raw('DATE_FORMAT(end_probationary_coefficient, "%m-%d")'),$arr)->get();
        return $data;
     }

     public function timesheet()
    {
        return $this->hasMany('App\Http\Models\Timesheet','employee_id');
    }       
 public function advance()
    {
        return $this->hasMany('App\Http\Models\Advance','employee_id');
    }     
 public function overtime()
    {
        return $this->hasMany('App\Http\Models\Overtime','employee_id');
    }        
}