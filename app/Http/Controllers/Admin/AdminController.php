<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Zone;
use App\Team;
use App\User;
use App\Question;
use App\Feedback;
use Auth;
use File;
use App\Admin;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
    	$zones_count 	=	Zone::count();
        $users_count   	=   User::count();
        $team_count     =   Team::count();
        $questions_count=   Question::count();
        $feedback_count=   Feedback::count();
    	return view('admin/index',compact('zones_count','users_count','team_count','questions_count','feedback_count'));
    }
    public function myprofile()
    {
        return view('admin.profile.index');
    }
    public function profile(Request $request){
        
        // return $request->all();
        $id = Auth::id();

        $old_profile                 = $request->input('old_profile');

        $old_profile_check           = 'src/storage/app/public/'.$old_profile;

        if(File::exists($old_profile_check)){
            // echo $old_profile_check; die();
            File::delete($old_profile_check);

            
        }
            $profile 			     = $request->file('profile');
            $profile_name            = md5(date("Ymdhis")).'.'.$profile->getClientOriginalExtension();
            $profile_destinationPath = storage_path('app/public/');

            $profile->move($profile_destinationPath, $profile_name);

            $admin = Admin::find($id);
            $admin->profile_image = $profile_name;
            $admin->save();

        
        return redirect()->back()->with('success' , 'profile updated successfully');
    }
    public function personal(Request $request){

        $id       = Auth::id();
        $name     = $request->name;
        $email    = $request->email;
        /*$check_admin_email 	=	Admin::where('email',$email)->first();
        if($check_admin_email)
        {
        	return redirect()->back()->with('warning' , 'Email is already exists');
        }*/

        $admin = Admin::find($id);
        $admin->name = $name;
        $admin->email = $email;
        $admin->save();
        return redirect()->back()->with('success' , 'updated successfully');
    }
    public function logindetails(Request $request)
    {
        $request->validate(['password' => 'required|confirmed']);
        $password  =   $request->password;
        $id        = Auth::id();
        $admin     = Admin::find($id);
        $admin->password = Hash::make($password);
        $admin->save();
        return redirect()->back()->with('success' , 'Password updated successfully');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->to('admin-login');
    }
    
}
