<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\User;
use App\Classes\Helpers;
use Excel;
use Validator;
use DB;
use File;

class UserController extends Controller
{
    private $data;
    private $column;
       public function __construct()
    {
        $this->data = User::all();
        $column  = DB::getSchemaBuilder()->getColumnListing('users');
        $this->column = array_diff($column, array("id","avatar","active_code","created_at","updated_at"));
    }

  public function showLogin(){
        if(session()->has("logined")){
            $manage = session()->get('manage');
            return redirect($manage.'/index');
        }
        //Nếu tồn tại session đăng nhập sẽ trả về edit-profile
        return view("admin.pages.login");
    }
     public function showLock(){
          $user_lock = session()->get('logined');
          $data = User::get_user_info($user_lock);
          session()->forget("logined");
          $return = view("admin/pages/lock");
          $return -> user  = $data->username;
          $return -> email = $data->email;
          $return -> avatar = $data->avatar;
        return $return;
    }
    
   public function doLogin(Request $request){
         $data = $request->input('data');
         $d = json_decode($data);
         if(!empty($d->radio)){
          session()->put("shift",$d->radio);   
         }
        if(User::check_login($d->username,md5(sha1($d->password)))){
            $data = User::get_user_info($d->username);
            if($data->manage == 1){
            $user = $data->username;
            $avatar = $data->avatar;
            session()->put("logined",$user);
            session()->put('avatar',$avatar);
            Helpers::save_history_action('login', '');
             return response()->json([
                'status' 	 => true,
            ]);   
            }else{
              return response()->json([
                'status' 	 => false,
                'message' => trans('messages.you_not_permission_admin'),
            ]);  
            }   
	}else{
             return response()->json([
                'status' 	 => false,
                'message' => trans('messages.username_or_password_not_correct'),
            ]);
        }
    }  
    
     public function showProfile(){
          $user = session()->get('logined');
          $data = User::get_user_info($user);
          return view("admin/pages/profile",['user'=>$data]);  
    }
     public function updateprofile(Request $request){
        $data = $request->input('data');
        $d = json_decode($data);    
           $result = User::find($d -> id);
           $result -> fullname  = $d -> fullname;
           $result -> firstname = $d -> firstname;
           $result -> lastname  = $d -> lastname;
           $result -> phone     = $d -> phone;
           $result -> birthday  = $d -> birthday;
           $result -> jobs      = $d -> jobs;
           $result -> address   = $d -> address;
           $result -> city      = $d -> city;
           $result -> country   = $d -> country;
           $result -> about     = $d -> about;
           $result -> identity_card = $d -> identity_card;
           $result -> save();           
            return response()->json([
                'status' 	 => true,
                 'message' => trans('messages.success_update'),
            ]);	     
        }
     public function changepassword(Request $request){
        $data = $request->input('data');   
        $d = json_decode($data);   
        $username = session()->get('logined');
        $new_password = md5(sha1($d->new_password));
        $user = User::get_user($username,md5(sha1($d->old_password)));
        if($user){
        $user -> password = $new_password ;
        $user->save();
        session()->forget("logined");
	  return response()->json([
                'status' 	 => true,
                 'message' => trans('messages.success_change_password'),
            ]);   
	}else{
             return response()->json([
                'status' 	 => false,
                'message' => trans('messages.error_change_password'),
            ]);
        }
    }
     public function uploadfile(Request $request){
		$file = $request->file('avatar')[0];
		$input = array('avatar' => $file);
		$rules = array(
			'image' => 'image|max:3000'
		);
		$validator = Validator::make($input, $rules);
		if ( $validator->fails() )
		{        
			return response()->json(['success' => false,'message' => trans('messages.error_change_avatar'), 'errors' => $validator->getMessageBag()->toArray()]);
		}
		else {
			$destinationPath = 'public/uploads/avatar/user/';
                        $ext             = $file->guessClientExtension();  
                        
			$filename        = $file->getClientOriginalName();                       
                        
                        
                        $username = session()->get('logined');
                        
                        $hashname           = str_random(30).'.'.$ext;
                        $user = User::get_user_info($username);
                        File::Delete($user -> avatar);
                        $user -> avatar = $destinationPath.$hashname ;
                        $user->save();
			$request->file('avatar')[0]->move($destinationPath, $hashname); 
			return response()->json(['success' => true,'message' => trans('messages.success_change_avatar'), 'avatar' => asset($destinationPath.$filename)]);
		}

    }
     public function resetpassword(Request $request){
        $data = $request->input('data');   
        $d = json_decode($data);   
        $new_password = md5(sha1($d->password));
        $user = User::get_user_info($d->email);
        if($user){
        $user -> password = $new_password ;
        $user->save();
	   return response()->json([
                 'status' 	 => true,
                 'message' => trans('messages.success_change_password'),
            ]);   
	}else{
             return response()->json([
                'status' 	 => false,
                'message' => trans('messages.error_change_password'),
            ]);
        }
    }
    
    
    
    public function showPage(){
        return view("admin.pages.listUser",['data'=>$this->data]);
    }
  public function save(Request $request){
        $colum = $this->column;
        $data = $request->input('data');
        $t = json_decode($data);     
        $user_check ='';$email_check ='';
            if($t->oper=='add'||$t->oper=='copy'){
            $return = new User();
           $user_check = User::get_user_info($t->username);
           $email_check = User::get_user_info($t->email);
             }else{
            $return = User::find($t->id);
            }
             if(!$user_check && !$email_check){      
            foreach($colum as $value){
                   if($value=='password'){
                       if($t-> $value == $return->password){
                   $return->$value           = $return->password;             
                       }else{
                   $return->$value           = md5(sha1($t-> $value,0));
                       }
                   }else{
                   $return->$value           = Helpers::get_not_null($t-> $value,0); 
                   }
            }            
            $return->save();
            $lst_data =  User::get_all($return->id);       
            Helpers::save_history_action($t->oper, serialize($lst_data->toArray()));
             return response()->json( [
                'status' 	 => true,
                'data'             => $lst_data,
                'message' => trans('messages.success_update'),
            ]);
          }else{
             return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.username_email_available'),
                 ]);
         }     
	            
    }  
        
     public function delete(Request $request){
         $id = $request->input('id');
         $check = false;
         if($check ==true){
              return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_delete'),
            ]);  
         }else{
         $result = User::find($id);
         Helpers::save_history_action('delete', serialize($result->toArray()));
	 $result -> delete();
            return response()->json( [
                'status' 	 => true,
                'message' => trans('messages.success_delete'),
            ]); 
        }            
    }
    
     public function export(){   
       Excel::create('ExcelFormImport', function ($excel) {
  
        $excel->sheet('User', function ($sheet) {

            // getting data to display - in my case only one record
            $table = $this->column;

            // setting column names for data - you can of course set it manually
            $sheet->appendRow($table); // column names

            // getting last row number (the one we already filled and setting it to bold
//            $sheet->row($sheet->getHighestRow(), function ($row) {
             $sheet->row(1 , function ($row) {
                $row->setFontWeight('bold');
                $row->setBackground('#DCDCDC');
                $row->setFontColor('#FFA500');
            });

            // putting users data as next rows
//            foreach ($table as $t) {
//                $sheet->appendRow($t);
//            }
        });

    })->download('xls');
    }
    
    public function import(Request $request){
          $colum = $this->column;
          $file = $request->file('file');
          $filename = explode('.', $file->getClientOriginalName()) ;        
          if($filename[1]=='xls'||$filename[1]=='csv'||$filename[1]=='xlsx'){
          $sheet = Excel::load($file, function($reader) {})->get(); 
          $count = 0;
          foreach($sheet as $sh){  
                $return = new User();
                foreach($colum as $value){
                     if($value=='password'){
                   $return->$value           = md5(sha1($sh-> $value,0));  
                   }else{
                   $return->$value           = Helpers::get_not_null($sh-> $value,0);    
                   }
                }      
                $return -> save();
                $data[$count] = User::get_all($return->id); 
                $content[$count] = $data[$count]->toArray();
                $count++; 
          }
           Helpers::save_history_action('import', serialize($content));
           return response()->json( [
                'status' 	 => true,
                'data'           => $data,
                'message' => trans('messages.success_import').' - '.$count.' '.trans('global.row'),
            ]);
          }else{
           return response()->json( [
                'status' 	 => false,
                'message' => trans('messages.error_import'),
              ]);
          }
    }
    
}
  