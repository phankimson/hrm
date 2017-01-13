<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
	public $table="advance";
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
        $data = Advance::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_employee($period=null,$department=null){
        $data = Advance::join('employee','employee.id','=','advance.employee_id')->TypeWhereIn('employee.department_id',$department)->TypeWhere('advance.period_id',$period)->get();
        return $data;
    }
 
}