<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Description;
use App\Http\Controllers\Controller;
use App\Mail\SendOTPMailer;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use App\SubCategory;
use App\Team;
use App\TeamUser;
use App\TeamZone;
use App\User;
use App\Question;
use App\Zone;
use App\UserDevice;
use App\QuestionZone;
use App\HintQuestion;
use App\UsertokenHistory;
use App\Usertoken;
use App\Feedback;
use App\Taunt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Mail;
use Response;
use Validator;
use DB;

class UserController extends Controller
{
    
    // register api
    
    public function register(Request $request) 
    { 
       	// return $request->all();
       	if(is_null($request->full_name))
        {
       		$error = ['status'=> 0 ,'message'=> "Please enter fullname"];
       		return response()->json($error);
       	}
        else if(is_null($request->email))
        {
       		$error = ['status' => 0 ,'message'=> "Please enter email address"];
       		return response()->json($error);
       	}
        else if($this->checkEmail($request->email) == 0)
        {
          $error = ['status' => 0 ,'message'=> "email address already exists"];
          return response()->json($error);
        }
        else if($this->validEmail($request->email) == 0)
        {
          $error = ['status' => 0 ,'message'=> "please enter a valid email"];
          return response()->json($error);
        }
        
        else if(is_null($request->password))
        {
       		$error = ['status' => 0 ,'message'=> "Please enter password"];
       		return response()->json($error);
       	}
        else
        {
       		// return $request->all();
			    $input               = $request->all(); 
          $input['password']   = bcrypt($input['password']);
	        $user                = User::create($input);
          if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
          { 
            $user         =  Auth::user(); 
            // return $user;
            $id           =  $user->id;
            $token        =  $user->createToken('MyApp')->accessToken;
            $device_type  =  $request->device_type;
            $device_id    =  $request->device_id;
            
            if(!is_null($device_type) && !is_null($device_id))
            {
              if($this->checkDeviceID($id,$device_type,$device_id) == 0)
              {
                //return 'not found';
                $user_device = new UserDevice;
              }
              else
              {
                //return 'found';
                $user_device = UserDevice::where(['user_id'=>$id,'device_type'=>$device_type])->first();
              }
              $user_device->user_id     = $id;
              $user_device->device_type = $device_type;
              $user_device->device_id   = $request->device_id;
              $user_device->save();
            } 
                return response()->json(['status'=> 1,'access_token'=> $token,'token_type' => 'Bearer']);
          } 
          else
          { 
              return response()->json(['error'=>'Unauthorised'], 401); 
          } 
			   return response()->json(['status'=> 1,'message'=> "User registered successfully"]); 
       	}
       	
		
    }
    

    public function checkEmail($email){
    	$id = User::where('email',$email)->get()->count();
    	if($id == 0){
    		return 1;
    	}else{
    		return 0;
    	}
    }

    public function validEmail($email){
    	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    		return 1;
    	}else{
    		return 0;
    	}
    }


    // login api
    public function login(Request $request){
      if(is_null($request->email))
      {
        $error = ['status' => 0 ,'message'=> "Please enter email"];
        return response()->json($error);
      }
     	elseif(is_null($request->password))
      {
        $error = ['status' => 0 ,'message'=> "Please enter password"];
        return response()->json($error);
      }

      else
      {


        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        { 
            //return 'calleddddd';
              $user         =  Auth::user(); 
              // return $user;
              $id           =  $user->id;
              $user_status  =  $user->active;
              $check_team   =  TeamUser::where('user_id',$id)->first();
              if($check_team AND $user_status==1)
              {
                $assigned     = 'true';
              }
              else
              {
                $assigned     = 'false';
              }
              // return $check_team;
              $token        =  $user->createToken('MyApp')->accessToken;
              $device_type  =  $request->device_type;
              $device_id    =  $request->device_id;
              
              if(!is_null($device_type) && !is_null($device_id))
              {
                if($this->checkDeviceID($id,$device_type,$device_id) == 0)
                {
                  //return 'not found';
                  $user_device = new UserDevice;
                }
                else
                {
                  //return 'found';
                  $user_device = UserDevice::where(['user_id'=>$id,'device_type'=>$device_type])->first();
                }
                $user_device->user_id     = $id;
                $user_device->device_type = $device_type;
                $user_device->device_id   = $request->device_id;
                $user_device->save();
              } 
              return response()->json(['status'=> 1,'assigned' => $assigned,'access_token'=> $token,'token_type' => 'Bearer']);
          } 
          else
          { 
              return response()->json(['error'=>'Unauthorised'], 401); 
          } 
        }
        
    }

    public function checkDeviceID($id,$type,$device_id){
      $chk = UserDevice::where(['user_id'=>$id,'device_type'=>$type,'device_id' =>$device_id])->get();
      if(count($chk) > 0){
        return 1;
      }else{
        return 0;
      }
    }
	// user details api
    public function user_details() 
    { 
        $user = Auth::user(); 
        if (Auth::user())
        {
          return response()->json(['status'=> 1,'user'=> $user]);
        }
        else
        {
          return response()->json(['error'=>'Unauthorised'], 401); 
        }
         
    } 

    public function get_user_profile()
    {
      $user = Auth::user();
      $user_id = $user->id;
      $points_query         = "SELECT SUM(`earn_points`) as total_points from question_zones where user_id=$user_id and `is_correct` =1";
      $get_points           =  DB::select($points_query,[]);
      if($get_points !=NULL)
      {
        $total_points =  $get_points[0]->total_points;
      }
      else
      {
        $total_points =0;
      }
      $total_tokens         =  Usertoken::where('user_id',$user_id)->first();
      $total_tokens =  $total_tokens->total_tokens;
      $user['total_points'] = $total_points;
      $user['total_tokens'] = $total_tokens;
      if (Auth::user())
      {
        return response()->json(['status'=> 1,'user'=> $user]);
      }
      else
      {
        return response()->json(['error'=>'Unauthorised'], 401); 
      }
    }

    public function update_user_profile(Request $request)
    {
      $user_id  = Auth::user()->id;
      $user     = User::find($user_id);
      $folderName       = 'public/images/profile/';
      if($request->full_name)
      {
        $user->full_name = $request->full_name;
      }
      if($request->file('profile_image'))
      {
        $image_path = "public/images/profile/".$user->profile_image;
        if(File::exists($image_path)) 
        {
          File::delete($image_path);
        }
        // $image_base_64    =  base64_decode($request->profile_image);
        // $safeName         =  str_random(10).'.'.'jpg';
        // $destinationPath  =  public_path() . $folderName;
        // $success          =  file_put_contents(public_path().'/images/profile/'.$safeName, $image_base_64);
        // $icon             = $safeName;
        // $user->profile_image = $icon;

        $images=$request->file('profile_image');
        $images_name_one=md5(rand('123456','999999')).'.'.$images->getClientOriginalExtension();
        $images_destination=public_path('images/profile/');
        $images->move($images_destination,$images_name_one);
        $user->profile_image = $images_name_one;
      }
      
      $user->save();  
      $user     = User::find($user_id);
      $profile_image = $user->profile_image;
      return response()->json(['status'=> 1,'message'=> "Profile updated successfully",'profile_image'=>$profile_image,'user_name' => $user->full_name]);
    }

    public function updatePassword(Request $request)
    {
      $user_id    = Auth::user()->id;
      $password   = $request->old_password;
      if(is_null($request->old_password))
      {
        $error = ['status' => 0 ,'message'=> "Please enter old password"];
        return response()->json($error);
      }
      elseif(!\Hash::check($request->old_password, Auth::user()->password))
      {
        $error = ['status' => 0 ,'message'=> "You have entered wrong password"];
        return response()->json($error);
      }
      elseif(is_null($request->new_password))
      {
        $error = ['status' => 0 ,'message'=> "Please enter new password"];
        return response()->json($error);
      }
      /*elseif(is_null($request->confirm_password))
      {
        $error = ['status' => 0 ,'message'=> "Please enter confirm password"];
        return response()->json($error);
      }
      elseif($request->new_password != $request->confirm_password)
      {
        $error = ['status' => 0 ,'message'=> "New password and confirm password are not same"];
        return response()->json($error);
      }
      $user = $this->validUser($user_id);
      if($user == 0)
      {
        $response = ['status' => 0 ,'message'=> "user not authorised"];
      }*/
      else
      {
        $user           = User::find($user_id);  
        $user->password = bcrypt($request->new_password);
        $update = $user->save();
        if($update)
        {
          $response = ['status' => 1 ,'message'=> "Password updated successfully"];
        }
        else
        {
          $response = ['status' => 0 ,'message'=> "Something went Wrong"];
        }
      }
      return response()->json($response);
    }

    // user logout
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
          'status' => 1,
            'message' => 'Successfully logged out'
        ]);
    }


    // change password 
    public function forgotPassword(Request $request)
    {
    	if(is_null($request->email))
      {
       		$error = ['status' => 0 ,'message'=> "Please enter email address"];
       		return response()->json($error);
      }
      else if($this->validEmail($request->email) == 0)
      {
       		$error = ['status' => 0 ,'message'=> "please enter a valid email"];
       		return response()->json($error);
      }
      else if($this->checkEmail($request->email) == 1)
      {
       		$error = ['status' => 0 ,'message'=> "please enter authorised email address"];
       		return response()->json($error);
      }
      else
      {

     		$otp          = rand(9999,1000);
        $user         = User::where('email',$request->email)->first();
        $user->otp    = $otp;
        $update       = $user->save();
        if($update)
        {
          $name       = $user->full_name;
          $subject    = "Change Password OTP";
     			$email      = $user->email;
     			//Mail::to($email)->send(new SendOTPMailer($name,$subject,$otp));
          $response   = ['status' => 1 ,'message'=> "otp send to your email address",'id'=>$user->id,'otp' =>$otp];
     			return response()->json($response);
     		}
        else
        {
     			$response = ['status' => 0 ,'message'=> "Something went Wrong"];
     			return response()->json($response);
     		}
      }
    }
    
    public function validUser($id){
      $chk = User::where('id',$id)->first();
      if($chk == null){
        return 0;
      }else{
        return 1;
      }
    }
    // verifyOtp
    public function verifyOtp(Request $request)
    {
    	$id    = $request->id;
    	$otp 	 = $request->otp;
      if(is_null($request->otp))
      {
        $error = ['status' => 0 ,'message'=> "Please enter otp"];
        return response()->json($error);
      }
      else
      {
        $user     = $this->validUser($id);
        if($user == 0)
        {
          $response = ['status' => 0 ,'message'=> "user not authorised"];
        }
        else
        {
          $data = User::findorFail($id);
          if($otp != $data->otp)
          {
            $response = ['status' => 0 ,'message'=> "otp not matched"]; 
          }
          else
          {
            $data->otp = "0101";
            $data->save();
            $response = ['status' => 1 ,'message'=> "otp verified successfully"];
          } 
        }
        return response()->json($response);
      }
    }

    // changePassword
    public function changePassword(Request $request)
    {
    	$id        = $request->id;
      $password  = $request->password;
      if(is_null($request->password))
      {
        $error = ['status' => 0 ,'message'=> "Please enter password"];
        return response()->json($error);
      }
      $user = $this->validUser($id);
      if($user == 0)
      {
        $response = ['status' => 0 ,'message'=> "user not authorised"];
      }
      else
      {
        $user = User::find($id);  
        $user->password = bcrypt($password);
        $update = $user->save();
        if($update)
        {
          $response = ['status' => 1 ,'message'=> "Password changed successfully"];
        }
        else
        {
          $response = ['status' => 0 ,'message'=> "Something went Wrong"];
        }
      }
      return response()->json($response);
    }

    // update profile

    /*public function updateProfile(Request $request) 
    { 
        $id = Auth::user()->id;
        // return $request->all();
        if(is_null($request->fname)){
          $error = ['status'=> 0 ,'message'=> "Please enter first name"];
          return response()->json($error);
        }else if(is_null($request->lname)){
          $error = ['status' => 0 ,'message'=> "Please enter last name"];
          return response()->json($error);
        }else if(is_null($request->mobile)){
          $error = ['status' => 0 ,'message'=> "Please enter mobile number"];
          return response()->json($error);
        }else if(is_null($request->email)){
          $error = ['status' => 0 ,'message'=> "Please enter email address"];
          return response()->json($error);
        }else if($this->validMobile($request->mobile) == 0){
          $error = ['status' => 0 ,'message'=> "Please enter valid mobile number"];
          return response()->json($error);
        }else if($this->validEmail($request->email) == 0){
          $error = ['status' => 0 ,'message'=> "please enter a valid email"];
          return response()->json($error);
        }else{
          if(is_null($request->image)){
            $icon = "";
          }else{
            $image_base_64 = base64_decode($request->image);
            $folderName = 'public/images/profile/';
            $safeName =    str_random(10).'.'.'jpg';
            $destinationPath = public_path() . $folderName;
            $success = file_put_contents(public_path().'/images/profile/'.$safeName, $image_base_64);
            $icon = $folderName.$safeName;  
          }
          $user = User::find($id); 
          $user->fname = $request->fname;
          $user->lname = $request->lname;
          $user->mobile = $request->mobile;
          $user->email = $request->email;
          $user->profile_image = $icon;
          $user->save();
          return response()->json(['status'=> 1,'message'=> "profile updated successfully",'user'=>$user]); 
        }
    }*/

    // user status 
    public function userStatus(Request $request){
         $id = Auth::user()->id;
         $status = $request->status;
         $user = User::find($id);
         $user->status = $status;
         $user->save();
         $status = $user->status;
         return response()->json(['status'=> 1,'message'=> "status updated successfully",'user_status'=>$status]); 
    }

    public function get_data()
    {
      $category               = Category::all();
      $sub_category           = SubCategory::all();
      foreach ($category as $key => $value) {
        $data[$key] = $value;
        $data[$key]['sub_category'] = SubCategory::where('cat_id',$value->id)->get();
      }
      return response()->json(['data'=> $data,'status' =>1]);
    }

    public function get_all_data()
    {
      $data = \DB::select("select `categories`.`title`, `sub_categories`.`sub_title`, `descriptions`.`id` as `description_id`, `descriptions`.`cat_id`, `descriptions`.`subcat_id`, `descriptions`.`desp`, `descriptions`.`section` from `categories` inner join `sub_categories` on `categories`.`id` = `sub_categories`.`cat_id` inner join `descriptions` on `descriptions`.`subcat_id` = `sub_categories`.`id` GROUP BY `descriptions`.`id`");
      return response()->json(['data'=> $data,'status' =>1]);

    }
    public function available_zones()
    {
      $user_id    = Auth::user()->id;
      $data       = [];
      $team_data  = TeamUser::join('teams','teams.id','team_users.team_id')->where('user_id',$user_id)->first();
      // return $team_data;
      $data['team_name']  = $team_data->team_name;
      $points_query  = "SELECT SUM(`earn_points`) as total_points from question_zones where user_id=$user_id and `is_correct` =1";
      $get_points = DB::select($points_query);
      $data['total_points'] =  $get_points[0]->total_points;
      $total_tokens =  Usertoken::where('user_id',$user_id)->first();
      $data['total_tokens'] = $total_tokens->total_tokens;
      $team_id    = $team_data->id;
      $zone_idss = DB::table('questions')->groupBy('zone_id')->pluck('zone_id');

      //return $zone_idss;
      $data['team_zones']  = TeamZone::join('zones','zones.id','team_zones.zone_id')->where('team_zones.team_id',$team_id)->whereIn('zones.id',$zone_idss)->get();
      foreach ($data['team_zones'] as $key => $value) {
        $get_zone_points  = QuestionZone::
                         select(DB::raw('sum(earn_points) as total_points'))
                         ->where('user_id', $user_id)
                         ->where('zone_id', $value->zone_id)
                         ->where('is_correct', 1)
                         ->get();
        // return $key;
        $total_points =  $get_zone_points[0]->total_points;
        if($total_points)
        {
         $data['team_zones'][$key]['points'] =  $total_points;
        }
        else
        {
          $data['team_zones'][$key]['points'] =  0;
        }

        $completed_riddles =  QuestionZone::where(['user_id' => $user_id,'zone_id'=>$value->zone_id])->whereIn('task_completed',[2,3])->count();
        // return $completed_riddles;
        if($completed_riddles)
        {
          $data['team_zones'][$key]['completed_riddles'] = $completed_riddles;
        }
        else
        {
          $data['team_zones'][$key]['completed_riddles'] = 0;
        }
      }


      return response()->json(['data'=> $data,'status' =>1]);
    }

    /*public function zone_riddles(Request $request)
    {
      $zone_id    = $request->zone_id;
      $team_id    = $request->team_id;
      $points     = $request->points;
      $zone_name  = Zone::find($zone_id)->zone_name;
      $team_name  = Team::find($team_id)->team_name;
      $questions  = [];
      $questions['10_points']  = Question::select('id as ques_id','task_completed')->where(['zone_id'=>$zone_id,'points' => 10])->get();
      $questions['20_points']  = Question::select('id as ques_id','task_completed')->where(['zone_id'=>$zone_id,'points' => 20])->get();
      $questions['30_points']  = Question::select('id as ques_id','task_completed')->where(['zone_id'=>$zone_id,'points' => 30])->get();
      $questions['40_points']  = Question::select('id as ques_id','task_completed')->where(['zone_id'=>$zone_id,'points' => 40])->get();
      return response()->json(['data'=> $questions,'zone_name'=>$zone_name,'team_name'=>$team_name,'status' =>1]);
    }*/

    public function zone_riddles(Request $request)
    {
      $user_id    = Auth::user()->id;
      $zone_id    = $request->zone_id;
      $team_id    = $request->team_id;
      $points     = $request->points;
      $zone_name  = Zone::find($zone_id)->zone_name;
      $team_name  = Team::find($team_id)->team_name;
      $main_array = [];

      $points_query   = "SELECT SUM(`earn_points`) as total_points from question_zones where user_id=$user_id and `is_correct` =1";
      $get_points     =  DB::select($points_query,[]);
      if($get_points !=NULL)
      {
        $total_points =  $get_points[0]->total_points;
      }
      else
      {
        $total_points =0;
      }
      $total_tokens =  Usertoken::where('user_id',$user_id)->first();
      $total_tokens =  $total_tokens->total_tokens;

      $completed_riddles =  QuestionZone::where(['user_id' => $user_id,'zone_id'=>$zone_id,'team_id' => $team_id])->whereIn('task_completed',[2,3])->count();
      $completed_riddles = $completed_riddles;
      // return $completed_riddles;
      $query = "SELECT  points, (select GROUP_CONCAT( id) ) as ques_id   from questions where zone_id=$zone_id  GROUP by points";
      $questions = DB::select($query,[]);

      foreach ($questions as $key => $value) {
        $points_key        = $value->points.'_points';
        $arr               = explode(',',$value->ques_id);
        //return $arr;
        foreach ($arr as $key1 => $value1) {
          $f_q        = Question::find($value1);
          $find_ques  = QuestionZone::select('ques_id','task_completed','is_correct')->where('user_id', $user_id)->where('ques_id',$f_q->id)->first();
          // return $find_ques;
          if($find_ques)
          {
            $task_completed = $find_ques['task_completed'];
            $is_correct     = $find_ques['is_correct'];
          }
          else
          {
            $task_completed = 0;
            $is_correct     = $find_ques['is_correct'];
          }
          $main_array[$points_key][$key1]['ques_id'] = (int)$value1;
          $main_array[$points_key][$key1]['task_completed'] = (int)$task_completed;
          $main_array[$points_key][$key1]['is_correct'] = (int)$is_correct;
        }
        
      }
      /*$questions['10_points']  = Question::select('questions.id as ques_id')->where(['questions.zone_id'=>$zone_id,'questions.points' => 10])->get();
      foreach ($questions['10_points'] as $key => $value) {
        $find_ques  = QuestionZone::select('ques_id','task_completed')->where('user_id', $user_id)->where('ques_id',$value->ques_id)->first();
        if($find_ques)
        {
          $task_completed = $find_ques['task_completed'];
        }
        else
        {
          $task_completed = 0;
        }
        $questions['10_points'][$key]['ques_id'] = $value['ques_id'];
        $questions['10_points'][$key]['task_completed'] = $task_completed;
      }*/
        //return$main_array;

      return response()->json(['status' =>1,'zone_name'=>$zone_name,'team_name'=>$team_name,'zone_id' =>$zone_id,'team_id' => $team_id,'total_points' =>$total_points,'total_tokens'=>$total_tokens,'completed_riddles' => $completed_riddles,'data'=> $main_array]);
    }

    public function get_riddles(Request $request)
    {
      
      $user_id        = Auth::user()->id;
      $zone_id        = $request->zone_id;
      $team_id        = $request->team_id;
      $ques_id        = $request->ques_id;
      $points         = $request->points;
      $task_completed = $request->task_completed;
      $question       = [];
      $token_for      = '';
      $find_zone      =  Zone::find($zone_id);
      $zone_image     =  $find_zone->zone_image;
      $total_tokens   =  Usertoken::where('user_id',$user_id)->first();
      $team_name      = Team::find($team_id)->team_name;
      $find_question  = Question::find($ques_id);
      $get_question   = $find_question->question;

      $query = "select GROUP_CONCAT(`id`) as hint_id from hint_questions where `question_id`=$ques_id";
      $hint_ids = DB::select($query,[]);
       $points_query         = "SELECT SUM(`earn_points`) as total_points from question_zones where user_id=$user_id and `is_correct` =1";
      $get_points           =  DB::select($points_query,[]);
      if($get_points !=NULL)
      {
        $total_points =  $get_points[0]->total_points;
      }
      else
      {
        $total_points =0;
      }

      if($task_completed == 0)
      {
          $find_ques      = QuestionZone::where(['user_id'=>$user_id,'team_id'=>$team_id,'zone_id'=>$zone_id,'points'=>$points,'ques_id'=>$ques_id])->first();
        if($find_ques)
        {
          $hint_used             = $find_ques->hint_used;
          $question              = $find_ques;
          $question['question']  = $get_question;
          $question['hint_used'] = $hint_used;
          $question['total_tokens'] =  $total_tokens->total_tokens;
          $question['total_points'] =  $total_points;
          $question['team_name']    =  $team_name;
          $question['zone_image']   =  $zone_image;
          $question['get_hints']    = QuestionZone::join('hint_questions','hint_questions.question_id','question_zones.ques_id')->select('hint_questions.id as hint_id','hint_questions.hint')->where('question_zones.ques_id',$ques_id)->where('user_id',$user_id)->get();
          return response()->json(['question'=> $question,'status' =>1]);
        }
        else
        {
            switch ($points) {
                case 10:
                  $token_for = 1;
                  break;

                  case 20:
                  $token_for = 2;
                  break;

                  case 30:
                  $token_for = 3;
                  break;

                  case 40:
                  $token_for = 4;
                  break;

                  default:
                  $token_for = 0;
                  break;
              }

              if($total_tokens->total_tokens >= $token_for)
              {
                $question_zone            = new QuestionZone();
                $question_zone->user_id   = $user_id;
                $question_zone->zone_id   = $zone_id;
                $question_zone->team_id   = $team_id;
                $question_zone->ques_id   = $ques_id;
                $question_zone->hint_id   = $hint_ids[0]->hint_id;
                $question_zone->points    = $points;
                $question_zone->task_completed    = 1;
                $question_zone->save();

                
                $token_history            = new UsertokenHistory();
                $token_history->user_id   = $user_id;
                $token_history->ques_id   = $ques_id;
                $token_history->token_for = 1;
                $token_history->token_desc= $token_for.' token';
                $token_history->save();

                $usertoken                = Usertoken::where('user_id',$user_id)->first();
                $usertoken->total_tokens  = $usertoken->total_tokens - $token_for;
                $usertoken->save();

                $question              = $question_zone;
                $question['question']  = $get_question;
                $question['hint_used'] = $question_zone->hint_used;
                $question['total_tokens'] =  $usertoken->total_tokens;
                $question['total_points'] =  $total_points;
                $question['team_name']    =  $team_name;
                $question['zone_image']    =  $zone_image;

                $question['get_hints']    = QuestionZone::join('hint_questions','hint_questions.question_id','question_zones.ques_id')->select('hint_questions.id as hint_id','hint_questions.hint')->where('question_zones.ques_id',$ques_id)->where('user_id',$user_id)->get();
                return response()->json(['question'=> $question,'status' =>1]);
                
            }
            else
            {

              return response()->json(['question'=> new \stdClass(),'status' =>0]);
            }
        
      }
    }
      else
      {
        $find_ques      = QuestionZone::where(['user_id'=>$user_id,'team_id'=>$team_id,'zone_id'=>$zone_id,'points'=>$points,'ques_id'=>$ques_id])->first();
        $hint_used             = $find_ques->hint_used;
        $question              = $find_ques;
        $question['question']  = $get_question;
        $question['hint_used'] = $hint_used;
        $question['total_tokens']   =  $total_tokens->total_tokens;
        $question['total_points']   =  $total_points;
        $question['team_name']      =  $team_name;
        $question['zone_image']    =  $zone_image;
        $question['get_hints']      =  QuestionZone::join('hint_questions','hint_questions.question_id','question_zones.ques_id')->select('hint_questions.id as hint_id','hint_questions.hint')->where('question_zones.ques_id',$ques_id)->where('user_id',$user_id)->get();
          return response()->json(['question'=> $question,'status' =>1]);
        
      }
    }

    public function get_hint(Request $request)
    {
      $hint_id    = $request->hint_id;
      $team_id    = $request->team_id;
      $zone_id    = $request->zone_id;
      $ques_id    = $request->ques_id;
      $user_id    = Auth::user()->id;

      $find_ques   = QuestionZone::where(['user_id' => $user_id,'team_id' => $team_id,'ques_id' => $ques_id])->first();

      $hint_ids    = explode(',',$find_ques->hint_id);
      $hint_length =  count($hint_ids);
      if(in_array($hint_id, $hint_ids))
      {
        // return 'matched';
        if($find_ques->hint_used <=$hint_length)
        {
          $find_ques->hint_used = $find_ques->hint_used + 1;
          $find_ques->save();
        }
      }
      $usertoken =Usertoken::where('user_id',$user_id)->first();
      $usertoken->total_tokens = $usertoken->total_tokens - 1;
      $usertoken->save();
      //return $hint_ids;

      $find_hint  = HintQuestion::find($hint_id)->hint;
      return response()->json(['data'=> $find_hint,'usertoken'=>$usertoken['total_tokens'],'status' =>1]);
    }

    public function submit_riddle(Request $request)
    {
      // return $request->all();
      $team_id    = $request->team_id;
      $zone_id    = $request->zone_id;
      $ques_id    = $request->ques_id;
      $points     = $request->points;
      $answer     = $request->answer;
      $user_id    = Auth::user()->id;
      $earn_points= '';
      $earn_tokens= '';
      // $find_ques   = QuestionZone::where(['user_id' => $user_id,'team_id' => $team_id,'ques_id' => $ques_id,'zone_id' =>$zone_id,'points' => $points])->first();
      $find_ques   = QuestionZone::join('questions','questions.id','question_zones.ques_id')
                    ->select('question_zones.*','questions.answer as correct_answer')
                    ->where(['question_zones.user_id' => $user_id,'question_zones.team_id' => $team_id,'question_zones.ques_id' => $ques_id,'question_zones.zone_id' =>$zone_id,'question_zones.points' => $points])->first();
      // return $find_ques;
      if($find_ques->task_completed == 2 and $find_ques->is_correct ==1)
      {
        return response()->json(['message'=> 'Already submitted the question','status' =>2]);
      }
      elseif($find_ques->task_completed == 3)
      {
        return response()->json(['message'=> 'Already abandoned the question','status' =>3]);
      }
      else
      {
          $is_hint_used = $find_ques['hint_used'];
          switch ($points) {
                case 10:
                $earn_tokens = 2;
                break;

                case 20:
                // $earn_tokens = 4;
                $earn_tokens = 3;
                break;

                case 30:
                // $earn_tokens = 6;
                $earn_tokens = 4;
                break;

                case 40:
                // $earn_tokens = 8;
                $earn_tokens = 5;
                break;

                default:
                $earn_tokens = 0;
                break;
              }
          if($is_hint_used == 0)
          {
              switch ($points) {
                case 10:
                $earn_points = 10;
                //$deduct_tokens = 0;
                break;

                case 20:
                $earn_points = 20;
                //$deduct_tokens = 0;
                break;

                case 30:
                $earn_points = 30;
                //$deduct_tokens = 0;
                break;

                case 40:
                $earn_points = 40;
                //$deduct_tokens = 0;
                break;

                default:
                $earn_points = 0;
                //$deduct_tokens = 0;
                break;
              }
          }
          elseif($is_hint_used == 1)
          {
              switch ($points) {
                case 20:
                $earn_points = 20;
                //$deduct_tokens = 1;
                break;

                case 30:
                $earn_points = 30;
                //$deduct_tokens = 1;
                break;

                case 40:
                $earn_points = 40;
                //$deduct_tokens = 1;
                break;

                default:
                $earn_points = 0;
                //$deduct_tokens = 0;
                break;
              }
          }
          elseif($is_hint_used == 2)
          {
              switch ($points) {
                case 30:
                $earn_points = 30;
                //$deduct_tokens = 2;
                break;

                case 40:
                $earn_points = 40;
                //$deduct_tokens = 2;
                break;

                default:
                $earn_points = 0;
                //$deduct_tokens = 0;
                break;
              }
          }
          elseif($is_hint_used == 3)
          {
              switch ($points) {
              
                case 40:
                $earn_points = 40;
                //$deduct_tokens = 3;
                break;

                default:
                $earn_points = 0;
                //$deduct_tokens = 0;
                break;
              }
          }
          if($answer == $find_ques->correct_answer)
          {
            $find_ques->user_answer  = $answer;
            $find_ques->earn_points  = $earn_points;
            $find_ques->earn_tokens  = $earn_tokens;
            $find_ques->task_completed= 2;
            $find_ques->is_correct= 1;
            $find_ques->save();

            $tokens     = Usertoken::where(['team_id'=>$team_id,'user_id'=> $user_id])->first();
            $tokens->total_tokens   = $tokens['total_tokens'] + $earn_tokens;
            $tokens->save();
            $status   = 1;
          }
          else
          {
            $find_ques->user_answer  = $answer;
            //$find_ques->earn_points  = $earn_points;
            //$find_ques->earn_tokens  = $earn_tokens - $deduct_tokens;
            //$find_ques->task_completed= 2;
            $find_ques->save();
            $find_ques->is_correct= 0;

            /*$tokens     = Usertoken::where(['team_id'=>$team_id,'user_id'=> $user_id])->first();
            $tokens->total_tokens   = $tokens->total_tokens -  $deduct_tokens;
            $tokens->save();*/
            $status   = 2;
          }
          
          return response()->json(['message'=> 'ok','status' =>$status]);
      }
    }

    public function submit_abandoned(Request $request)
    {
      $team_id    = $request->team_id;
      $zone_id    = $request->zone_id;
      $ques_id    = $request->ques_id;
      $points     = $request->points;
      $answer     = 'abandoned';
      $user_id    = Auth::user()->id;
      $earn_points= 0;
      $return_tokens= '';
      $find_ques   = QuestionZone::where(['user_id' => $user_id,'team_id' => $team_id,'ques_id' => $ques_id,'zone_id' =>$zone_id,'points' => $points])->first();
      if($find_ques)
      {
        if($find_ques->task_completed == 2 and $find_ques->is_correct == 1)
        {
          return response()->json(['message'=> 'Already submitted the question','status' =>2]);
        }
        elseif($find_ques->task_completed == 3)
        {
          return response()->json(['message'=> 'Already abandoned the question','status' =>3]);
        }
        else
        {
          $find_ques->user_answer  = $answer;
          $find_ques->earn_points  = $earn_points;
          $find_ques->task_completed= 3;
          $find_ques->save();

          switch ($points) {
              case 10:
              $return_tokens = 1;
              break;

              case 20:
              // $return_tokens = 1;
              $return_tokens = 2;
              break;

              case 30:
              // $return_tokens = 1;
              $return_tokens = 3;
              break;

              case 40:
              // $return_tokens = 1;
              $return_tokens = 4;
              break;

              default:
              $return_tokens = 0;
              break;
            }
            $usertoken  = Usertoken::where('user_id',$user_id)->first();
            $usertoken->total_tokens = $usertoken->total_tokens + $return_tokens;
            $usertoken->save();


          return response()->json(['message'=> 'Riddle is abandoned successfully','status' =>1]);
        }
      }
    }

    public function submit_feedback(Request $request)
    {
      $user_id            = Auth::user()->id;
      $ques_id            = $request->ques_id;
      $feedback_1         = $request->feedback;
      $feedback           = new Feedback();
      $feedback->user_id  = $user_id;
      $feedback->ques_id  = $ques_id;
      $feedback->feedback = $feedback_1;
      $feedback->save();
      return response()->json(['message'=> 'Feedback is sent successfully','status' =>1]);

    }

    public function submit_taunt(Request $request)
    {
      $from_user_id     = Auth::user()->id;
      // return $from_user_id;
      $from_team        = TeamUser::where('user_id',$from_user_id)->first();
      //return $from_team['team_id'];
      $user_name        = Auth::user()->full_name;
      $to_team_id       = $request->team_id;
      $to_team_user_ids = TeamUser::select('user_id')->where('team_id',$to_team_id)->get();
      // return $to_team_user_ids;
      $message          = $request->message;

      $check_tokens     = Usertoken::where('user_id',$from_user_id)->first();
      $total_tokens     = $check_tokens->total_tokens;
      if($total_tokens < 50)
      {
        return response()->json(['message'=> "You don't have sufficient tokens for sending taunt",'status' =>0]);
      }
      else
      {
        $optionBuilder        = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);
        $notificationBuilder  = new PayloadNotificationBuilder($user_name);
        $notificationBuilder->setBody($request->message)
                    ->setSound('default');
        $dataBuilder      = new PayloadDataBuilder();
      //  $dataBuilder->addData(['a_data' => 'my_data']);
        $dataBuilder->addData(['notification_type' =>'notification']);

        $option         = $optionBuilder->build();
        $notification   = $notificationBuilder->build();
        $data           = $dataBuilder->build();

        /*$token = "c_C6KGoanc0:APA91bF2-9Qwd4queeSny32ag_Nv41b9FUsYbJTFs37nddA7hBLE7MH42LKE-hkGWvijFW1GXytKSnvWbuUfS9Jnv3InnLOtA4ifCXrx-mdI5Q6d_7rJmPXFXvie8TSJ9Rf9yHTPn_DN";*/
        foreach ($to_team_user_ids as $key => $to_user_id) {
          //return $to_user_id->user_id;
          $user_device[$key]      =   UserDevice::where('user_id',$to_user_id->user_id)->select('device_id')->get()->all();
        }
        
        //dd($user_device);
        //return $user_device;
        $tokens = array();
        $i = 0;
        if($user_device)
        {
          foreach ($user_device as $key => $value) {
            foreach ($value as $key1 => $value1) {
              //return $value1;
            $tokens[$i] = $value1->device_id;
            }
            $i++;
          }
          //$get_user_device  = $user_device->device_id;
          // return $tokens;
          $downstreamResponse   = FCM::sendTo($tokens, $option, $notification, $data);
          $downstreamResponse->numberSuccess();
          $downstreamResponse->numberFailure();
          $downstreamResponse->numberModification();
        }
        $taunt                = new Taunt();
        $taunt->from_user_id  = $from_user_id;
        $taunt->from_team_id  = $from_team['team_id'];
        $taunt->to_team_id    = $to_team_id;
        $taunt->message       = $message;
        $res                  = $taunt->save();
        if($res)
        {
          $check_tokens->total_tokens = $check_tokens->total_tokens - 50;
          $check_tokens->save();
          return response()->json(['message'=> "Taunt is sent successfully",'status' =>1]);

        }
      }
    }

    public function get_leaderboard()
    {
      $all_teams  = Team::where('status',1)->get();
      // $all_teams  = Team::all();
      // return $all_teams;
      $new_arr    = [];
      /*$get_zone_points  = QuestionZone::
                          join('teams','teams.id','question_zones.team_id')
                          ->select('teams.id',DB::raw('sum(question_zones.earn_points) as points'),'teams.team_name','teams.status')
                          ->groupBy('team_id')
                          //->where('team_id', $value->id)
                          ->where('is_correct', 1)
                          ->orderBy('points', 'DESC')
                          ->get();
      // return $get_zone_points;*/
      foreach ($all_teams as $k => $value) {

         $get_zone_points  = QuestionZone::
                         select(DB::raw('sum(earn_points) as total_points'))
                         ->where('team_id', $value->id)
                         ->where('is_correct', 1)
                         
                         ->get();
        $total_points =  $get_zone_points[0]->total_points;
        // return $get_zone_points;
        if($total_points AND $total_points !=null)
        {
          $team_pointd  = $total_points;
        }
        else
        {
          $team_pointd  = 0;
        }

        $new_arr[$k]['id']          = $value->id;
        $new_arr[$k]['team_name']   = $value->team_name;
        $new_arr[$k]['status']      = $value->status;
        $new_arr[$k]['points']      = $team_pointd;
      }
      $res = $this->bubble_sort($new_arr);
      return response()->json(['data'=> $res,'status' =>1]);
    }

    public function bubble_sort($arr) {
    $size = count($arr)-1;
    for ($i=0; $i<$size; $i++) {
        for ($j=0; $j<$size-$i; $j++) {
            $k = $j+1;
            if ($arr[$k]['points'] > $arr[$j]['points']) {
                // Swap elements at indices: $j, $k
                list($arr[$j], $arr[$k]) = array($arr[$k], $arr[$j]);
            }
        }
    }
    return $arr;
}

    public function get_teammate()
    {
      $user_id  = Auth::user()->id;
      $team_id  = TeamUser::where('user_id',$user_id)->first();
      $teammate = TeamUser::join('users','users.id','team_users.user_id')
                  ->select('team_users.user_id','team_users.team_id','users.full_name')->where('team_users.team_id', $team_id->team_id)->where('team_users.user_id','!=',$user_id)->get();
      //return $teammate;
      return response()->json(['data'=> $teammate,'status' =>1]);
    }

    public function get_team_members(Request $request)
    {
      $user_id  = Auth::user()->id;
      $team_id  = $request->team_id;
      $teammate = TeamUser::join('users','users.id','team_users.user_id')
                  ->select('team_users.user_id','team_users.team_id','users.full_name','users.profile_image')->where('team_users.team_id', $team_id)->where('team_users.user_id','!=',$user_id)->get();
      //return $teammate;
      if($teammate)
      {
        return response()->json(['data'=> $teammate,'status' =>1]);
      }
      else
      {
        return response()->json(['data'=> new \stdClass() ,'status' =>0]);
      }
    }

    public function get_team()
    {
      $all_teams  = Team::select('teams.id as team_id','teams.team_name as full_name')->get();
      return response()->json(['data'=> $all_teams,'status' =>1]);
    }

    

}
