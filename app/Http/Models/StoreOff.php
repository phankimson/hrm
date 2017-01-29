<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class StoreOff extends Model
{
	public $table="store_off";
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
        $data = StoreOff::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_period($period=null){
        $data = StoreOff::TypeWhere('period_id',$period)->get();
        return $data;
    }
}