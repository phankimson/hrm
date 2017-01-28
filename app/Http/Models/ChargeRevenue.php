<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeRevenue extends Model
{
	public $table="charge_revenue";
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
        $data = ChargeRevenue::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_period($period=null){
        $data = ChargeRevenue::TypeWhere('period_id',$period)->get();
        return $data;
    }
}