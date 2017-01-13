<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class FormatVoucher extends Model
{
	public $table="format_vouchers";
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
        $data = FormatVoucher::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_code($code){
        $data = FormatVoucher::where('code',$code)->first();
        return $data;
    }
}