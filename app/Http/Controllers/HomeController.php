<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Show the application Home .
     *
     * @return view
     */
    public function index()
    {
        return redirect()->route('posts');
    }
}
