<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Feedback;
use App\Http\Controllers\NotificationsController;

class FeedbacksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('web', ['only' => ['show']]);
        $this->middleware('auth', ['only' => ['create', 'store']]);
        $this->middleware('assign.guard:admin', ['only' => ['list', 'close']]);
    }

    public function index()
    {
        $feedbacks = Feedback::where('user_id', '=', auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('feedbacks.index')->with('feedbacks', $feedbacks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
          'title' => 'required',
          'message' => 'required',
      ]);
      $feedback = new Feedback;
      $feedback->title = $request->input('title');
      $feedback->message = $request->input('message');
      $feedback->user_id = auth()->user()->id;
      if($feedback->save()){
        return redirect('about')->with('success', 'Feedback was sent Successfully');
      }
      return redirect('about')->with('success', 'Feedback was sent Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $feedback = Feedback::find($id);
        return view('feedbacks.show')->with('feedback',$feedback);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /* Not supported for this controller
    public function edit($id)
    {
        //
    }
    */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /* Not supported for this controller
    public function update(Request $request, $id)
    {
        //
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $feedback = Feedback::find($id);
      if(auth()->user()->id != $feedback->user_id || !Auth::guard('admin')->check()){ //only admin and feedback's owner
        return redirect('home')->with('error', 'Unauthorized User!');
      }

      if($feedback->delete()){
        return redirect('about')->with('success', 'feedback Removed Successfully');
      }
      return redirect('about')->with('error', "Couldn't remove the feedback ");

    }

    //for admin
    public function list(){
      $feedbacks = Feedback::all();
      return view('manage.feedbacks')->with('feedbacks', $feedbacks);
    }

    public function close($id){
      $feedback = Feedback::find($id);
      $feedback_id = $feedback->id;
      $feedback->closed = 1;
      NotificationsController::send('feedback closure', Feedback::find($feedback_id)->user_id, $feedback_id);
      if($feedback->save()){
        return redirect('admin/feedbacks')->with('success', 'feedback Closed Successfully');
      }
      return redirect('admin/feedbacks')->with('error', "Couldn't close the selected feedback");

    }

}
