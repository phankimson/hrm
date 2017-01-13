<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	public $table="department";
	public $timestamps = false;
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
        $data = Department::TypeWhere('id',$id)->get();
        return $data;
    }
   public static function get_active($id=null){
        $data = Department::TypeWhere('id',$id)->where('active','=',1)->get();
        return $data;
    }
}