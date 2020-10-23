<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Team;
use App\TeamUser;
use App\Zone;
use App\TeamZone;
use App\HintQuestion;
use App\QuestionZone;
use App\Usertoken;
use DB;

class UsersPerformanceController extends Controller
{
    public function user_list()
    {
    	$user_list 	=	User::get();
    	return view('admin.performance.user_list',compact('user_list'));
    }

    public function question_performance_list($user_id,$zone_id)
    {
        $question_list  =   QuestionZone::
                            join('questions','questions.id','question_zones.ques_id')
                            ->join('zones','zones.id','question_zones.zone_id')
                            ->select('questions.question','questions.answer','questions.hints_per_challenge','tokens_wons','question_zones.id','question_zones.points','question_zones.earn_points','question_zones.earn_tokens','question_zones.ques_id','question_zones.user_answer','question_zones.hint_used','question_zones.task_completed','zones.zone_name','question_zones.is_correct')
                            ->where('question_zones.user_id',$user_id)
                            ->where('question_zones.zone_id',$zone_id)
                            ->get();
        //$question_list  =   Question::join('zones','zones.id','questions.zone_id')->select('questions.*','zones.zone_name')->where('zone_id',$zone_id)->get();
        // return $questions;
        return view('admin.performance.question_list',compact('question_list','user_id','zone_id'));

    }

    public function change_status(Request $request)
    {
        $status     =   $request->status;
        $id         =   $request->id;

        $find_question  =   QuestionZone::find($id);
        $find_question->is_correct   =   $status;
        $find_question->save();
        if($status == 1)
        {
            $tokens     =   Usertoken::where(['user_id' =>$find_question->user_id,'team_id' => $find_question->team_id])->first();
            $tokens->total_tokens = $tokens->total_tokens + $find_question->earn_tokens;
            $tokens->save();
        }
        return response()->json(['status' =>1,'success_mgs' =>'Status updated successfully']);
    }

}
