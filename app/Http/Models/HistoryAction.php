<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryAction extends Model
{
	public $table="history_action";
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
        
        public function formattedDate()
        {
            return $this->created_at->diffForHumans();
        }
        /**
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
      
    public static function get_all($id=null){
        $data = HistoryAction::TypeWhere('id',$id)->get();
        return $data;
    }
    public static function get_index(){
        $data = HistoryAction::join('users','users.id','=','history_action.user_id')->join('menu','menu.id','=','history_action.menu_id')->select('history_action.*','menu.code','users.username')->orderBy('history_action.created_at','desc')->get();
        return $data;
    }
}