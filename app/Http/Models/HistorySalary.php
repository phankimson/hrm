<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class HistorySalary extends Model
{
	public $table="history_salary";
        protected $fillable = array('id');
         protected $dates = ['created_at', 'updated_at', 'deleted_at'];
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
        $data = HistorySalary::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_employee_last($employee){
        $data = HistorySalary::where('employee_id',$employee)->orderBy('updated_at', 'desc')->first();
        return $data;
    }
}