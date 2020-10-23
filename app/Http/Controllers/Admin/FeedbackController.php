<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Zone;
use App\Question;
use App\HintQuestion;
use App\Feedback;
use Illuminate\Support\Facades\Input;

class FeedbackController extends Controller
{
    public function feedback_list()
    {
    	$feedback_list 	=	Feedback::join('questions','questions.id','feedback.ques_id')
                            ->join('users','users.id','feedback.user_id')
                            ->select('feedback.*','questions.question','users.full_name')
                            ->orderBy('feedback.id', 'DESC')
                            ->get();
        // return $feedback_list;
    	return view('admin.feedback.feedback_list',compact('feedback_list'));
    }

    
}
