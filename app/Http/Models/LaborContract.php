<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class LaborContract extends Model
{
    public $table="labor_contract";
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
        $data = LaborContract::TypeWhere('id',$id)->get();
        return $data;
    }
         public static function get_end($arr = null){
           $data = LaborContract::join('employee','employee.id','=','labor_contract.employee_id')->TypeWhereBetween(DB::raw('DATE_FORMAT(contract_end, "%m-%d")'),$arr)->get();
        return $data;
     }
}   