<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Team;
use App\TeamUser;
use App\Zone;
use App\TeamZone;
use App\Usertoken;

class TeamController extends Controller
{
    public function team_list()
    {
    	$team_list 	=	Team::orderBy('id', 'DESC')->get();
    	return view('admin.team.team_list',compact('team_list'));
    }

    public function team_form($id="")
    {
    	$rs       = Team::find($id);
    	return view('admin.team.team_form',compact('rs'));
    }
    public function store(Request $request)
    {
    	// return $request->all();
    	$input = request()->validate([
				'team_name' => 'required'
				],[
				'team_name.required' => 'Please enter Team Name'
				]);

    	if($request->con=="add") 
	    {
			$team 		    	= 	new Team;
			$team->team_name    =	$request->team_name;
			$team->save();
	        return redirect()->to('admin/manage-teams')->with(['message' => 'Team added successfully']);


		}
		elseif($request->con=="edit") 
	    {
			$team 		    	= 	Team::find($request->id);
			$team->team_name    =    $request->team_name;
            $team->save();
	        return redirect()->to('admin/manage-teams')->with(['message' => 'Team updated successfully']);
		}
    }
    public function del_team($id)
    {
       $stm = Team::find($id);
       $stm->delete();
       return redirect()->back()->with("message","Team deleted successfully");
    }

    public function team_users_form($team_id)
    {
        $team_users     =   TeamUser::all();
        $team_name      =   Team::find($team_id);
        $team_users_id  =   $team_users->pluck('user_id');
        $users          =   User::whereNotIn('id', $team_users_id)->get();;
        //$users_id       =   $users->pluck('id');
        $get_team_users =   TeamUser::join('users','users.id','team_users.user_id')->select('users.*')->where('team_id',$team_id)->get();
        // return $get_team_users;
        return view('admin.team.team_user_form',compact('team_id','users','get_team_users','team_name'));
    }
    public function post_team_users(Request $request)
    {
        // return $request->all();
        $input = request()->validate([
                'users_id' => 'required'
                ],[
                'users_id.required' => 'Please select atleast one user to assign a team'
                ]);
        if($request->con == 'add')
        {
            foreach ($request->users_id as $key => $value) {
                $obj          = new TeamUser();
                $obj->team_id = $request->team_id;
                $obj->user_id = $value;
                $obj->save();

                $user           =   User::find($value);
                $user->active   = 1;
                $user->save();

                $usertokens = Usertoken::where(['user_id' =>$value])->first();
                if($usertokens)
                {
                    // return $usertokens;
                    $usertokens->team_id = $request->team_id;
                    $usertokens->is_assign = 1;
                    $usertokens->save();
                }
                else
                {
                    $obj_token          = new Usertoken();
                    $obj_token->team_id = $request->team_id;
                    $obj_token->user_id = $value;
                    $obj_token->is_assign = 1;
                    $obj_token->save();
                }
                
            }
        }
        return back()->with('message', 'Successfully added users');
    }

    public function team_zones_form($team_id)
    {
        $zone_list      =   Zone::all();
        $team_name      =   Team::find($team_id);
        $get_team_zones =   TeamZone::join('zones','zones.id','team_zones.zone_id')->select('zones.*')->where('team_id',$team_id)->get();
        
        // return $get_team_zones;
        return view('admin.team.team_zones_form',compact('team_id','zone_list','team_name','get_team_zones'));
    }
    public function post_team_zones(Request $request)
    {
        // return $request->all();
        $input = request()->validate([
                'zone_id' => 'required'
                ],[
                'zone_id.required' => 'Please select atleast one zone to assign a team'
                ]);
        if($request->con == 'add')
        {
            foreach ($request->zone_id as $key => $value) {
                $obj          = new TeamZone();
                $obj->team_id = $request->team_id;
                $obj->zone_id = $value;
                $obj->save();
                
            }
        }
        return back()->with('message', 'Successfully added zones');
    }

    public function delete_team_user($id,$team_id)
    {
        $find_user  =   TeamUser::where('user_id',$id)->first();
        if($find_user)
        {
            $find_user->delete();
            $usertokens = Usertoken::where(['user_id' =>$id,'team_id' =>$team_id])->first();
            // return $usertokens;
            if($usertokens)
            {
                $usertokens->is_assign = 0;
                $usertokens->save();
            }

            $user   =   User::find($id);
            $user->active = 0;
            $user->save();

            return redirect()->back()->with('delete_message', 'Successfully deleted users');
        }
        
    }

    public function delete_team_zone($id)
    {
        $find_zone      =   TeamZone::where('zone_id',$id)->first();
        // return $find_zone;
        if($find_zone)
        {
            $find_zone->delete();
            return redirect()->back()->with('delete_message', 'Successfully deleted zone');
        }
        
    }

    public function update_status($id, $status = 0) 
    {
     
    $id =base64_decode($id);
    
    $stm = Team::find($id);
    
    $stm->status = $status;
    $stm->save();   
    return back()->with('message', 'Status changed Successfully.');
  }
}
