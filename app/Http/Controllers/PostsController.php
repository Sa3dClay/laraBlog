<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Like;
use DB;
use App\Http\Controllers\NotificationsController;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$posts = Post::all(); /* get all posts */
        //$posts = DB::select('SELECT * FROM posts'); /* for database */
        //$posts = Post::orderBy('id', 'asc')->get(); /* for ordering */
        //$posts = Post::orderBy('id', 'asc')->take(1)->get(); /* max NO posts to return */

        $posts = Post::orderBy('id', 'desc')->where('hidden','=',0)->paginate(5);
        return view('posts.index')->with('posts', $posts);

        // we can also use: Post::where('name', 'value')->get(); to return specific post
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
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
            'body' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        // Create Post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->category = $request->input('category');
        $post->user_id = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $image_name = $_FILES['image']['name'];
            $destPath   = public_path('uploads');
            $imgPath    = $destPath.'/'.$image_name;

            if(!file_exists($imgPath)) {
                $image->move($destPath, $image_name);
            }
            $post->image_name = $image_name;

        } else if ($request->input('image_select')) {
            $image_name = $request->input('image_select');
            $post->image_name = $image_name;
        }

        $post->save();
        NotificationsController::send('new post',0 ,$post->id); // 0 is insignificant

        return redirect('/posts')->with('success', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        if($post->hidden) {
            return redirect()->back()->with('error', 'Sorry, this post is hidden!');
        }

        if(isset(auth()->user()->id))
        {
            $user_id = auth()->user()->id;

            $post_likes = DB::table('likes')->where('post_id', $id)->get();
            $like = DB::table('likes')->where('post_id', $id)->where('user_id', $user_id)->first();

            return view('posts.show')->with('post', $post)->with('likes', $post_likes)->with('like', $like);
        }

        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        // Check for right user
        if(auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024'
        ]);

        // Edit Post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->category = $request->input('category');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $image_name = $_FILES['image']['name'];
            $destPath   = public_path('uploads');
            $imgPath    = $destPath.'/'.$image_name;

            if(!file_exists($imgPath)) {
                $image->move($destPath, $image_name);
            }
            $post->image_name = $image_name;

        } else if ($request->input('image_select')) {
            $image_name = $request->input('image_select');
            $post->image_name = $image_name;
        }

        $post->save();

        return redirect('/posts')->with('success', 'Post Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        // Check for right user
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->with('error', 'Unauthorized Page');
        }

        $post->delete();

        return redirect('/home')->with('success', 'Post Removed Successfully');
    }

    /**
     * add a like to the post.
     *
     * @param  \Illuminate\Http\Request  $post_id
     * @param  int  $post_id
     * @return \Illuminate\Http\Response
     *
     */
    public function like(Request $request) {
        $user_id = auth()->user()->id;
        $post_id = $request->post_id;

        //send a notification to post's owner
        NotificationsController::send('like', Post::find($post_id)->user_id, $post_id);

        $user_likes = DB::table('likes')->where('user_id', $user_id)->get();

        if ($user_likes)
        {
            foreach ($user_likes as $like)
            {
                if($like->post_id == $post_id)
                    return redirect()->back()->with('error', 'You Already Like This Post');
            }
        }

        $like = new Like();
        $like->post_id = $post_id;
        $like->user_id = $user_id;
        $like->save();

        $likes = Like::all();

        $post_likes = DB::table('likes')->where('post_id', $post_id)->get();

        // return redirect()->back()->with('success', 'Like Added Successfully');

        return response()->json([
            'success'=>'like successfully added to the post',
            'like'=>$like,
            'likes'=>$post_likes
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $link_id
     * @return \Illuminate\Http\Response
     */
    public function dislike(Request $request)
    {
        $like_id = $request->like_id;
        $like = Like::find($like_id);

        if(auth()->user()->id !== $like->user_id) {
            return redirect()->back()->with('error', 'Unauthorized Action');
        }

        $like->delete();

        $post_id = $request->post_id;
        $post_likes = DB::table('likes')->where('post_id', $post_id)->get();
        
        //delete sent-notification
        NotificationsController::delete('like', $post_id, null);

        // return redirect()->back()->with('success', 'Disliked Successfully');

        return response()->json([
            'success'=>'like successfully removed from the post',
            'likes'=>$post_likes
        ]);
    }

    public function getWhoLike(Request $request) {
        $post_id = $request->post_id;

        $likers = DB::table('likes')
            ->where('likes.post_id', '=', $post_id)
            ->join('users', 'users.id', '=', 'likes.user_id')
            ->select('users.name as user_name')
            ->get();

        return response()->json([
            'msg'=>'get likers successfully',
            'likers'=>$likers
        ]);
    }

    // Search
    public function search(Request $request){
        $strword = $request->input('search');
        $search_type = $request->input('searchField');

        // replace special characters with empty word
        $strword = preg_replace('/[^A-Za-z0-9\s\-]/', '', $strword);

        if( strlen($strword) == 0 ) {
            return back();
        }

        $str = strtolower($strword);
        //$chars = str_split($str);
        $str2 = '';
        $n = strpos($str, ' ');

        if(!is_numeric($n)) {
            //$str2 = implode($str2, $chars);
            $str2 = $str;

            if( strtolower($str2) == "computerscience&it"
                || strtolower($str2) == "computerscience"
                || strtolower($str2) == "it" ) {
                $str2 = 'cs';
            }

            if( strtolower($str2) == "problemdiscussion"
                || strtolower($str2) == "discussion"
                || strtolower($str2) == "problem" ) {
                $str2 = 'pd';
            }

            // check for search type
            if( $search_type != 'user' ) {

                $posts = Post::whereRaw("lower(title) like '%$str2%'")
                    ->orWhereRaw("lower(category) like '%$str2%'")
                    ->orWhereIn('user_id', function($query) use($str2){
                        $query->select('id')->from('users')->where('name', '=', "$str2");
                    })
                    ->orderBy('created_at', 'desc')->where('hidden','=',0)->paginate(5);

            } else {
                $posts = Post::find_no_space($str2 ); // for user search
            }

        } else {
            // split by spaces
            $newstr = explode(" ", $str);
            array_push($newstr, str_replace(' ', '', $str));

            for($i=0; $i<count($newstr); $i++) {
                $newstr[$i] = "'".$newstr[$i]."'";
            }

            if( strpos($str, "computer science & it") !== false
                || strpos($str, "computer science") !== false
                || strpos($str, "it") !== false) {
                array_push($newstr, "'cs'");
            }

            if ( strpos($str, "problem discussion") !== false
                || strpos($str, "discussion") !== false
                || strpos($str, "problem") !== false ) {
                array_push($newstr, "'pd'");
            }

            $words = implode(',', $newstr);
            // check for search type
            if( $search_type != 'user' ) {
                $posts = Post::whereRaw("lower(replace(title,' ','')) in ($words)")
                    ->orWhereRaw("lower(replace(category,' ','')) in ($words)")
                    ->orWhereIn('user_id', function($query) use($words) {
                        $query->select('id')->from('users')->whereRaw("lower(replace(name,' ','')) in ($words)");
                    })
                    ->orderBy('created_at', 'desc')->where('hidden','=',0)->paginate(5);
            } else {
                $posts = Post::find_space($words); // for user search
            }
        }

        if( $search_type == 'user' ) {
            return view('home')->with('posts', $posts);
        } else {
            return view('posts.index')->with('posts', $posts);
        }
    }

    // Draft
    public function draftSearch(Request $request) {
        $search_text = $request->input('search');
        $search_type = $request->input('searchField');

        $search_text = strtolower($search_text);

        if ( $search_type == "user" ) {

            $user_id = auth()->user()->id;

            $posts = Post::where('user_id', '=', $user_id)
                ->whereRaw('LOWER(`title`) LIKE ? ', ['%'. $search_text .'%'])
                ->orWhereRaw('LOWER(`category`) LIKE ? ', ['%'. $search_text .'%'])
                ->orderBy('created_at', 'desc')->paginate(5);

        } else {

            $posts = Post::whereRaw('LOWER(`title`) LIKE ? ', ['%'. $search_text .'%'])
                ->orWhereRaw('LOWER(`category`) LIKE ? ', ['%'. $search_text .'%'])
                ->orderBy('created_at', 'desc')->paginate(5);

        }
    }
}
