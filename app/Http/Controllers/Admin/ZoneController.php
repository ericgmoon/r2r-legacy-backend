<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Zone;
use App\Question;
use App\HintQuestion;
use Illuminate\Support\Facades\Input;

class ZoneController extends Controller
{
    public function zone_list()
    {
    	$zone_list 	=	Zone::orderBy('id', 'DESC')->get();
    	return view('admin.zone.zone_list',compact('zone_list'));
    }

    public function zone_form($id="")
    {
    	$rs           	= Zone::find($id);
    	return view('admin.zone.zone_form',compact('rs'));
    }
    public function store(Request $request)
    {
    	// return $request->all();
        $icon       =   '';
    	

    	if($request->con=="add") 
	    {
                $input = request()->validate([
                'zone_name' => 'required',
                'zone_image' => 'required',
                ],[
                'zone_name.required' => 'Please enter Zone Name',
                'zone_image.required' => 'Please choose Zone Image',
                ]);
            if($request->file('zone_image'))
            {
                $zone_image      = $request->file('zone_image');

                $image_filename         = time().$zone_image->getClientOriginalName();
                $image_destinationPath  = public_path('images/zone/');
                $zone_image->move($image_destinationPath, $image_filename);
            }
			$zone 		    	= 	new Zone();
			$zone->zone_name 	=	$request->zone_name;
            $zone->zone_image   =   $image_filename;
			$zone->save();
	        return redirect()->to('admin/manage-zone')->with(['message' => 'Zone added successfully']);


		}
		elseif($request->con=="edit") 
	    {

                $input = request()->validate([
                'zone_name' => 'required',
                ],[
                'zone_name.required' => 'Please enter Zone Name',
                ]);
			$zone 		    	= 	Zone::find($request->id);
            if($request->file('zone_image'))
            {
                $zone_image             = $request->file('zone_image');

                $image_filename         = time().$zone_image->getClientOriginalName();
                $image_destinationPath  = public_path('images/zone/');
                $zone_image->move($image_destinationPath, $image_filename);
            }
            else
            {
                $image_filename    =  $zone->zone_image;
            }
			$zone->zone_name    =   $request->zone_name;
            $zone->zone_image   =   $image_filename;
            $zone->save();
	        return redirect()->to('admin/manage-zone')->with(['message' => 'Zone updated successfully']);
		}
    }
    public function del_zone($id)
    {
       $stm = Zone::find($id);
       $stm->delete();
       return redirect()->back()->with("message","Zone deleted successfully");
    }

    public function question_list($zone_id)
    {
        $question_list  =   Question::join('zones','zones.id','questions.zone_id')->select('questions.*','zones.zone_name')->where('zone_id',$zone_id)->get();
        return view('admin.zone.question_list',compact('question_list','zone_id'));
    }

    public function question_form($zone_id,$id="")
    {
        $rs             = Question::find($id);
        $hints          = HintQuestion::where('question_id',$id)->get();
        $zone_list      = Zone::where('status',1)->get();
        return view('admin.zone.question_form',compact('rs','zone_list','zone_id','hints'));
    }
    public function question_store(Request $request)
    {
        // return $request->all();
        if($request->points == 10)
        {
            $input = request()->validate([
                'points'                => 'required',
                'question'              => 'required',
                'answer'                => 'required',
                ],[
                'points.required'       => 'Please choose points',
                'question.required'     => 'Please enter question',
                'answer.required'       => 'Please enter answer',
                ]);
        }
        elseif($request->points == 20)
        {
            $input = request()->validate([
                'points'                => 'required',
                'question'              => 'required',
                'answer'                => 'required',
                'hint_1'                => 'required',
                ],[
                'points.required'       => 'Please choose points',
                'question.required'     => 'Please enter question',
                'answer.required'       => 'Please enter answer',
                'hint_1.required'       => 'Please enter hint 1',
                ]);
        }
        elseif($request->points == 30)
        {
            $input = request()->validate([
                'points'                => 'required',
                'question'              => 'required',
                'answer'                => 'required',
                'hint_1'                => 'required',
                'hint_2'                => 'required',
                ],[
                'points.required'       => 'Please choose points',
                'question.required'     => 'Please enter question',
                'answer.required'       => 'Please enter answer',
                'hint_1.required'       => 'Please enter hint 1',
                'hint_2.required'       => 'Please enter hint 2'
                ]);
        }
        else
        {
            $input = request()->validate([
                'points'                => 'required',
                'question'              => 'required',
                'answer'                => 'required',
                'hint_1'                => 'required',
                'hint_2'                => 'required',
                'hint_3'                => 'required'
                ],[
                'points.required'       => 'Please choose points',
                'question.required'     => 'Please enter question',
                'answer.required'       => 'Please enter answer',
                'hint_1.required'       => 'Please enter hint 1',
                'hint_2.required'       => 'Please enter hint 2',
                'hint_3.required'       => 'Please enter hint 3'
                ]);
        }

        if($request->con=="add") 
        {
            $zone_id         = $request->zone_id;
            $get_no_of_ques  =   Question::where(['points'=>$request->points,'zone_id' => $request->zone_id])->count();
            // return $get_no_of_ques;
            $hint       =   [];
            if($request->points == 10)
            {
                $hints_per_challenge    = 0;
                $tokens_to_unlock       = 1;
                $tokens_wons            = 2;
                if($get_no_of_ques<4)
                {
                    $question  =   new Question;
                }
                else
                {
                    return redirect()->back()->with(['warning' => 'You have already added 4 questions for points 10'])->withInput(Input::all());
                }
            }
            elseif($request->points == 20)
            {
                $hints_per_challenge    = 1;
                $hint['hint_1']         = $request->hint_1;
                $tokens_to_unlock       = 2;
                $tokens_wons            = 4;
                if($get_no_of_ques<3)
                {
                    $question  =   new Question;
                }
                else
                {
                    return redirect()->back()->with(['warning' => 'You have already added 3 questions for points 20'])->withInput(Input::all());
                }
            }
            elseif($request->points == 30)
            {
                $hints_per_challenge    = 2;
                $hint['hint_1']         = $request->hint_1;
                $hint['hint_2']         = $request->hint_2;
                $tokens_to_unlock       = 3;
                $tokens_wons            = 6;
                if($get_no_of_ques<2)
                {
                    $question  =   new Question;
                }
                else
                {
                    return redirect()->back()->with(['warning' => 'You have already added 2 questions for points 30'])->withInput(Input::all());
                }
            }
            else
            {
                $hints_per_challenge    = 3;
                $hint['hint_1']         = $request->hint_1;
                $hint['hint_2']         = $request->hint_2;
                $hint['hint_3']         = $request->hint_3;
                $tokens_to_unlock       = 4;
                $tokens_wons            = 8;
                if($get_no_of_ques<1)
                {
                    $question  =   new Question;
                }
                else
                {
                    return redirect()->back()->with(['warning' => 'You have already added 1 question for points 40'])->withInput(Input::all());
                }
            }
            // return $hint;
            $question->zone_id              =   $request->zone_id;
            $question->points               =   $request->points;
            $question->hints_per_challenge  =   $hints_per_challenge;
            $question->question             =   $request->question;
            $question->answer               =   $request->answer;
            $question->tokens_to_unlock     =   $tokens_to_unlock;
            $question->tokens_wons          =   $tokens_wons;
            $question->save();
            if($hint)
            {
                foreach ($hint as $key => $value) {
                  $hint_obj                     =   new HintQuestion(); 
                  $hint_obj->question_id        =   $question->id;
                  $hint_obj->hint               =   $value;
                  $hint_obj->save();
                }
            }
            

            return redirect()->to('admin/manage-zone-questions/'.$zone_id)->with(['success' => 'Question added successfully']);


        }
        elseif($request->con=="edit") 
        {
            // return $request->all();
            $hint                           =   [];
            $hint_id                        =   [];
            $arr                            =   [];
            $question                       =   Question::find($request->id);
            if($question->zone_id==$request->zone_id AND $question->points==$request->points)
            {
                $question->question         =   $request->question;
                $question->answer           =   $request->answer;
                if($request->points == 10)
                {
                    $hints_per_challenge    = 0;
                    $tokens_to_unlock       = 1;
                    $tokens_wons            = 2;
                    
                }
                elseif($request->points == 20)
                {
                    $hints_per_challenge    = 1;
                    $hint['hint_1']         = $request->hint_1;
                    $hint_id['hint_id_1']   = $request->hint_id_1;
                    $tokens_to_unlock       = 2;
                    $tokens_wons            = 4;
                    
                }
                elseif($request->points == 30)
                {
                    $hints_per_challenge    = 2;
                    $hint['hint_1']         = $request->hint_1;
                    $hint['hint_2']         = $request->hint_2;
                    $hint_id['hint_id_1']   = $request->hint_id_1;
                    $hint_id['hint_id_2']   = $request->hint_id_2;
                    $tokens_to_unlock       = 3;
                    $tokens_wons            = 6;
                    
                }
                else
                {
                    $hints_per_challenge    = 3;
                    $hint['hint_1']         = $request->hint_1;
                    $hint['hint_2']         = $request->hint_2;
                    $hint['hint_3']         = $request->hint_3;
                    $hint_id['hint_id_1']   = $request->hint_id_1;
                    $hint_id['hint_id_2']   = $request->hint_id_2;
                    $hint_id['hint_id_3']   = $request->hint_id_3;
                    $tokens_to_unlock       = 4;
                    $tokens_wons            = 8;
                    
                }

                $arr    =    array_combine($hint_id,$hint);
                if($arr)
                {
                    foreach ($arr as $key => $value) {
                      $hint_obj       =   HintQuestion::find($key);
                      $hint_obj->hint =   $value;
                      $hint_obj->save();
                    }
                }
            }
            else
            {
                $get_no_of_ques  =   Question::where(['points'=>$request->points,'zone_id' => $request->zone_id])->count();
                // return $get_no_of_ques;
                if($request->points == 10)
                {
                    $hints_per_challenge    = 0;
                    $tokens_to_unlock       = 1;
                    $tokens_wons            = 2;
                    if($get_no_of_ques<4)
                    {
                        $question  =   new Question;
                    }
                    else
                    {
                        return redirect()->back()->with(['warning' => 'You have already added 4 questions for points 10'])->withInput(Input::all());
                    }
                }
                elseif($request->points == 20)
                {
                    $hints_per_challenge    = 1;
                    $hint['hint_1']         = $request->hint_1;
                    $hint_id['hint_id_1']   = $request->hint_id_1;
                    $tokens_to_unlock       = 2;
                    $tokens_wons            = 4;
                    if($get_no_of_ques<3)
                    {
                        $question  =   new Question;
                    }
                    else
                    {
                        return redirect()->back()->with(['warning' => 'You have already added 3 questions for points 20'])->withInput(Input::all());
                    }
                }
                elseif($request->points == 30)
                {
                    $hints_per_challenge    = 2;

                    $hint['hint_1']         = $request->hint_1;
                    $hint['hint_2']         = $request->hint_2;

                    $hint_id['hint_id_1']   = $request->hint_id_1;
                    $hint_id['hint_id_2']   = $request->hint_id_2;
                    $tokens_to_unlock       = 3;
                    $tokens_wons            = 6;
                    if($get_no_of_ques<2)
                    {
                        $question  =   new Question;
                    }
                    else
                    {
                        return redirect()->back()->with(['warning' => 'You have already added 2 questions for points 30'])->withInput(Input::all());
                    }
                }
                else
                {
                    $hints_per_challenge    = 3;
                    $hint['hint_1']         = $request->hint_1;
                    $hint['hint_2']         = $request->hint_2;
                    $hint['hint_3']         = $request->hint_3;
                    $hint_id['hint_id_1']   = $request->hint_id_1;
                    $hint_id['hint_id_2']   = $request->hint_id_2;
                    $hint_id['hint_id_3']   = $request->hint_id_3;
                    $tokens_to_unlock       = 4;
                    $tokens_wons            = 8;
                    if($get_no_of_ques<1)
                    {
                        $question  =   new Question;
                    }
                    else
                    {
                        return redirect()->back()->with(['warning' => 'You have already added 1 question for points 40'])->withInput(Input::all());
                    }
                }

                $question->zone_id              =   $request->zone_id;
                $question->points               =   $request->points;
                $question->hints_per_challenge  =   $hints_per_challenge;
                $question->tokens_to_unlock     =   $tokens_to_unlock;
                $question->tokens_wons          =   $tokens_wons;
                

            }
            $question->save();
            $arr    =    array_combine($hint_id,$hint);
            if($arr)
            {
                foreach ($arr as $key => $value) {
                  $hint_obj       =   HintQuestion::find($key);
                  $hint_obj->hint =   $value;
                  $hint_obj->save();
                }
            }
            
            
            return redirect()->to('admin/manage-zone-questions/'.$request->zone_id)->with(['success' => 'Question updated successfully']);
        }
    }

    public function update_status($id, $status = 0) 
    {
     
    $id =base64_decode($id);
    
    $stm = Zone::find($id);
    
    $stm->status = $status;
    $stm->save();   
    return back()->with('message', 'Status changed Successfully.');
  }
}
