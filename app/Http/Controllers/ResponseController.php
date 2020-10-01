<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response;
use App\Feedback;
use App\Notification;

class ResponseController extends Controller
{
  public function __construct()
  {
      $this->middleware('assign.guard:admin', ['store']);
  }

  public function responses($feedback_id, $user_id){ //feedback_id, user_id
      $responses = Response::where('feedback_id', $feedback_id)->where('user_id', $user_id)->get();
      $feedback = Feedback::find($feedback_id);
      $data = [
        'responses' => $responses,
        'feedback' => $feedback
      ];
      return view('components.responses')->with('data', $data);
  }

  public function store(Request $request){
    $this->validate($request, [
        'response' => 'required',
    ]);
     $response = new Response;
     $response->admin_id = $request->input('admin_id');
     $response->user_id = $request->input('user_id');
     $response->feedback_id = $request->input('feedback_id');
     $response->response = $request->input('response');
     if($response->save()){
       return redirect('/admin/feedbacks')->with('success', 'response was sent Successfully');
     }
     return redirect('/admin/feedbacks')->with('error', "Couldn't send your response ");
  }
}
