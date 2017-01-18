<?php

namespace AdiFaidz\Base\Http\Controllers\Client;

use Illuminate\Http\Request;

use AdiFaidz\Base\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('base::client.home');
    }
}
