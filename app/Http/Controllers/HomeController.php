<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$testimonials=\App\Testimonials::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		$sliders=\App\Sliders::where('status',1)->where('trash',0)->orderBy('id','DESC')->get();
		$causeCats=\App\CauseCategory::where('status',1)->where('trash',0)->orderBy('id','ASC')->get();
		if(Auth::check() && getUserRole(Auth::id())==2){
			return redirect('dashboard');
		}else{
			return view('home',compact('testimonials','sliders','causeCats'));
		}
    }
}
