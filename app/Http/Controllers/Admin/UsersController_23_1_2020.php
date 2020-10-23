<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Zone;
use App\Team;
use App\TeamUser;
use App\TeamZone;
use App\Usertoken;

class UsersController extends Controller
{
    public function user_list()
    {
    	$user_list 	=	User::orderBy('id', 'DESC')->get();
        // return $user_list;
        
    	return view('admin.users.user_list',compact('user_list'));
    }

    public function user_form($id="")
    {
    	$rs           	= User::find($id);
    	return view('admin.users.user_form',compact('rs'));
    }
    public function change_pwd($id)
    {
        return view('admin.users.change_pwd_form',compact('id'));
    }
    public function update_password(Request $request)
    {
        $input = request()->validate([
                'password'      => 'required|string|min:6|confirmed',
            ]);
        $id                 =   $request->id;
        $user               =   User::find($id);
        $user->password     =   bcrypt($request->password);
        $user->save();
        return redirect()->to('admin/manage-users')->with(['message' => 'User password updated successfully']);
    }
    public function assign_tokens($id)
    {
        $rs   =   Usertoken::where('user_id',$id)->first();
        // return $usertokens;
        return view('admin.users.assign_tokens_form',compact('id','rs'));
    }
    public function update_more_tokens(Request $request)
    {
        // return $request->all();
        $input = request()->validate([
                'more_tokens'  => 'required|numeric',
            ]);
        $id           =   $request->id;
        $team_id      =   '';
        $check_team   =  TeamUser::where('user_id',$id)->first();
        if($check_team['team_id'])
        {
            $team_id                    =   $check_team->team_id;
            $usertokens                 =   Usertoken::where('user_id',$id)->first();
            // return $usertokens;
            $usertokens->total_tokens   +=   $request->more_tokens;
            $usertokens->save();
            return redirect()->to('admin/manage-users')->with(['message' => 'Tokens assigned successfully successfully']);
        }
        else
        {
            return redirect()->to('admin/manage-users')->with(['message' => 'User should be assigned to a team first']);
        }

    }

    public function add_more_tokens($id)
    {
        $rs   =   Usertoken::where('user_id',$id)->first();
        // return $usertokens;
        return view('admin.users.assign_more_form',compact('id','rs'));
    }
    public function update_assign_tokens(Request $request)
    {
        // return $request->all();
        $input = request()->validate([
                'total_tokens'  => 'required|numeric',
            ]);
        $id           =   $request->id;
        $team_id      =   '';
        $check_team   =  TeamUser::where('user_id',$id)->first();
        // return $check_team->team_id;
        if($check_team['team_id'])
        {
            $team_id                    =   $check_team->team_id;
            $usertokens                 =   new Usertoken();
            $usertokens->total_tokens   =   $request->total_tokens;
            $usertokens->user_id        =   $id;
            $usertokens->team_id        =   $team_id;
            $usertokens->save();
            $find_user                  =   User::find($id);
            $find_user->active          =   1;
            $find_user->save();
            return redirect()->to('admin/manage-users')->with(['message' => 'Tokens assigned successfully successfully']);
        }
        else
        {
            return redirect()->to('admin/manage-users')->with(['error_message' => 'User should be assigned to a team first']);
        }

    }
    public function store(Request $request)
    {
    	// return $request->all();
    	if($request->con=="add") 
	    {
            $input = request()->validate([
                'full_name'     => 'required|string|max:255',
                'email'         => 'required|string|email|max:255|unique:users',
                'password'      => 'required|string|min:6|confirmed',
            ]);
			$user 		    	= 	new User;
			$user->full_name    =	$request->full_name;
			$user->email 	    =	$request->email;
			$user->password 	=	bcrypt($request->password);
			$user->save();
	        return redirect()->to('admin/manage-users')->with(['message' => 'User added successfully']);


		}
		elseif($request->con=="edit") 
	    {
            $input = request()->validate([
                'full_name'     => 'required|string|max:255'
            ]);
			$user 		    	= 	User::find($request->id);
			$user->full_name    =    $request->full_name;
	        $user->save();
	        return redirect()->to('admin/manage-users')->with(['message' => 'User updated successfully']);
		}
    }
    public function del_user($id)
    {
       $stm = User::find($id);
       $stm->delete();
       return redirect()->back()->with("success","User deleted successfully");
    }
}
