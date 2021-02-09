<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class PrincipalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
    	return view('Principal')->with('title',"Quimica A. G.");
    }
    public function  relative_k_overall(){

        return view('relative-k-overall')->with("title","Relative Kinetic");

    }
    public function BDKinetics()
    {
    	return view('BDKinetics')->with('title',"Kinetics");
    }
    public function userapi(Request $request) {
    		return $request->user();
    }
    public function Apps_Desktop(){
        return view('Apps_Desktop')->with('title','Desktop Applications');

    }
}
