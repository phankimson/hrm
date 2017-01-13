<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	public $table="menu";
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
        $data = Menu::TypeWhere('id',$id)->orderBy('position')->get();
        return $data;
    }  
    
     public static function get_code($code){
        $data = Menu::TypeWhere('code',$code)->first();
        return $data;
    }  
    
     public static function get_link($link){
        $data = Menu::TypeWhere('link',$link)->first();
        return $data;
    }  
    
    public static function get_menu_admin_index(){
        $data = Menu::orderBy('position')->where('active','=','1')->get();
        return $data;
    }     
}