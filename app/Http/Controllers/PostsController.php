<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Session;

class PostsController extends Controller
{

    function __construct()
    {
        $this->middleware('auth', ['except' => ['index' , 'show']]);
    }

    /**
     * Display a listing of the POSTS.
     *
     * @return all posts view 
     */
    public function index()
    {   
        //get posts
        $posts = Post::latest()->get();
        return view('posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return create view
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  $request
     * @return alert
     */
    public function store(Request $request)
    {

        // validation
        $this->validate(request() , [
            'title' => 'required' ,
            'body' => 'required' 
        ]);

        // default image name
        $image_name = "default_image.jpg";

        // check if there is image in request  
        if($request->hasFile('image'))
        {
            // upload and resize image by image intervention
            $image = $request->file('image');
            $filename = time().str_random(25). '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1366, 720)->save( public_path('/uploads/images/' . $filename ) );
            $image_name = $filename;
        }

        // insert into data base 
        Post::create([
            'image' => $image_name ,
            'title' => $request->title ,
            'body' => $request->body ,
            'user_id' => Auth::user()->id
        ]);

        // alert message and redirect
        Session::flash('alert', [ 'message' => 'Added successfully !' , 'type' => 'success' ]); 
        return redirect()->route('posts');   
    }

    /**
     * Display the specified post.
     *
     * @param  $post_id
     * @return view
     */
    public function show($id)
    {
        // get post
        $post = Post::find($id);

        //check if post is not empty 
        if ($post !== null) 
        {
            return view('posts.show', compact('post'));
        }
        
        // redirect
        return redirect()->route('home'); 
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param  $post_id
     * @return view
     */
    public function edit($id)
    {
        //get post
        $post = Post::find($id);

        //check if post is not empty 
        if ($post !== null) 
        {
            return view('posts.edit', compact('post'));
        }

        // redirect
        return redirect()->route('home'); 
    }

    /**
     * Update the specified post in storage.
     *
     * @param  $post_id
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function update( $id , Request $request)
    {
        // validation
        $this->validate(request() , [
            'title' => 'required' ,
            'body' => 'required' 
        ]);

        // get post
        $post = Post::find($id);
       
        // check if auth is admin or the same user
        if ($post->user_id == Auth::user()->id || Auth::user()->user_type_id == 1 )
        {

            // check if there is image in request   
            if($request->hasFile('image'))
            {
                // upload and resize image by image intervention
                $image = $request->file('image');
                $filename = time().str_random(25). '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(1366, 720)->save( public_path('/uploads/images/' . $filename ) );
                $post->image = $filename;
            }

            // update
            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();

            // alert message and redirect
            Session::flash('alert', [ 'message' => 'Added successfully :) !' , 'type' => 'success' ]); 
            return redirect()->route('posts');

        }
        else
        {
            // alert message and redirect
            Session::flash('alert', [ 'message' => 'Something went wrong :( !' , 'type' => 'danger' ]);
            return redirect()->route('posts');
        }
        
    }

    /**
     * Remove the specified post from storage.
     *
     * @param  $post_id
     * @return alert message
     */
    public function destroy($id)
    {
        // get post
        $post = Post::find($id);

        // check if auth is admin or the same user 
        if ($post->user_id == Auth::user()->id || Auth::user()->user_type_id == 1 )
        {
            $post->delete();
            // session and redirect 
            Session::flash('alert', [ 'message' => 'Deleted successfully :) !' , 'type' => 'success' ]); 
            return redirect()->route('posts');
        }
        else
        {
            // session and redirect 
            Session::flash('alert', [ 'message' => 'Something went wrong :( !' , 'type' => 'danger' ]);
            return redirect()->route('posts');
        }
    }
}
