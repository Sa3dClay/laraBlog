<?php

namespace App\Http\Controllers;

use App\Feedback;
use App\Http\Controllers\NotificationsController;
use App\Response;
use Illuminate\Http\Request;

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
        $this->middleware('auth', ['only' => ['create', 'store', 'mark_feedback']]);
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

        if ($feedback->save()) {
            NotificationsController::send('new feedback', 0, $feedback->id); // 0 is insignificant

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
        return view('feedbacks.show')->with('feedback', $feedback);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){}
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = Feedback::find($id);

        if (auth()->guard('user')->check()) {
            if (auth()->user()->id == $feedback->user->id) { // feedback's owner
                $res = $this->remove_feedback_nots($feedback);
            }

        } else if (auth()->guard('admin')->check()) { //only admin
            $res = $this->remove_feedback_nots($feedback);

        } else {
            return redirect('home')->with('error', 'Unauthorized User!');
        }

        if ($res) {
            return redirect('about')->with('success', 'feedback Removed Successfully');
        }

        return redirect('about')->with('error', "Couldn't remove the feedback ");
    }

    //for admin
    function list() {
        $feedbacks = Feedback::all();
        return view('manage.feedbacks')->with('feedbacks', $feedbacks);
    }

    public function close($id)
    {
        $feedback = Feedback::find($id);
        $feedback_id = $feedback->id;
        $feedback->closed = 1;
        
        NotificationsController::send('feedback closure', Feedback::find($feedback_id)->user_id, $feedback_id);

        if ($feedback->save()) {
            return redirect('admin/feedbacks')->with('success', 'feedback Closed Successfully');
        }

        return redirect('admin/feedbacks')->with('error', "Couldn't close the selected feedback");
    }

    public static function mark_feedback($id)
    {
        $hasResponse = Response::where('feedback_id', '=', $id)->first();
        
        if (isset($hasResponse)) {
            return true;
        }
        
        return false;
    }

    private function remove_feedback_nots($feedback)
    {
        if ($feedback->delete()) {
            // delete sent-notification
            NotificationsController::delete('feedback closure', $feedback->id, $feedback->created_at);
            NotificationsController::delete('feedback response', $feedback->id, $feedback->created_at);
            NotificationsController::delete('new feedback', $feedback->id, $feedback->created_at);

            return true;
        }

        return false;
    }
}