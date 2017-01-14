<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
	public $table="template";
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
        $data = Template::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_by_code($code){
        $value = Template::where('code','like',$code.'%')->get();
        return $value;
    }
}