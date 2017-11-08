<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;
use Session;

class UsersController extends Controller
{

    function __construct()
    {
        $this->middleware('auth', ['only' => ['update_avatar']]);
    }

    /**
     * show user profile.
     *
     * @return view of user
     */
    public function profile($id)
    {
        // get user
        $user = User::find($id);

        //check if user not empty 
        if ($user !== null ) 
        {
            return view('users.profile' , compact('user') );
        }
        
        // redirect to home
        return redirect()->route('home');
    }

    /**
     * update user avatar .
     *
     * @return alert + view 
     */
    public function update_avatar($id , Request $request)
    {
        // get user
    	$user = User::find($id);

        // check if this is the same user
    	if ($user->id == Auth::user()->id )
        {

            // check if there is image in request 
	        if($request->hasFile('image'))
            {
                // upload and resize image by image intervention
	            $image = $request->file('image');
	            $filename = time().str_random(25). '.' . $image->getClientOriginalExtension();
	            Image::make($image)->resize(200, 200)->save( public_path('/uploads/avatars/' . $filename ) );
	            $user->image = $filename;
	            $user->save();

	            // alert message and redirect
                Session::flash('alert', [ 'message' => 'Updated successfully :) !' , 'type' => 'success' ]);
	            return redirect()->route('users.profile' , $id);
	        }
    	}

    	// alert message and redirect
    	Session::flash('alert', [ 'message' => 'Something went wrong :( !' , 'type' => 'danger' ]);
    	return redirect()->route('users.profile' , $id);

    }
}
