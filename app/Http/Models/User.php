<?php
namespace App\Http\Models;
use Validator;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
	public $table="users";
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
        
	public static function check_login($user_input,$password){
		$array1=array('user_input'=>$user_input);
		$rules=array("user_input"=>"email");
		if(Validator::make($array1,$rules)->fails())
	            $check=User::where("username","=",$user_input)->where("password","=",$password)->where("active","=","1")->count(); 
		else{
                    $check=User::where("email","=",$user_input)->where("password","=",$password)->where("active","=","1")->count();
                }
		if($check>0) 
			return true;   
		else return false;
	}
        public static function get_user($user,$password){
               $user = User::where("username","=",$user)->where("password","=",$password)->first();
               return $user;
        }
        public static function get_user_info($user_input){
               $user = User::where("users.username","=",$user_input)->orwhere("users.email","=",$user_input)->first();
               return $user;
        }  
        public static function comfirm_code($email,$active_code){
               $user = User::where("active_code","=",$active_code)->where("email","=",$email)->first();
               return $user;
        }  
        public static function check_username($username){
		if(User::where("username","=",$username)->count()>0)
			return false;
		else return true;
	}
	public static function check_email($email){
		if(User::where("email","=",$email)->count()>0)
			return false;
		else return true;
	}
        
        public static function get_all($id=null){
        $data = User::TypeWhere('id',$id)->orderBy('created_at','desc')->get();
        return $data;
    }   
       
}