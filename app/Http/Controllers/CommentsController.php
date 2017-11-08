<?php

namespace App\Http\Controllers;

use App\comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class CommentsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  $post_id , $request
     * @return alert
     */
    public function store($post_id , Request $request)
    {
        //validation
        $this->validate(request() , [
            'body' => 'required' 
        ]);

        //create new comment with user_id from auth
        Comment::create([
            'body' => $request->body ,
            'user_id' => Auth::user()->id ,
            'post_id' => $post_id
        ]);

        // alert message and redirect
        Session::flash('alert', [ 'message' => 'Added successfully !' , 'type' => 'success' ]);   
        return redirect()->back();   
    }

}
