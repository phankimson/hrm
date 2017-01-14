<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public static function get_all($id=null){
        $data = LaborContract::TypeWhere('id',$id)->get();
        return $data;
    }
}   