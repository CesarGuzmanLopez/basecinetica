<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\q_db_molecules;

class DB_pk_koverall_Controller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){	
    	$this->middleware(['auth','role:admin,super-admin']);	
    }
    public function Molecules(){
    	return view('user/BD/pk-Koverall/Molecules')->with('title',"Molecules");
    }
    public function Solvents(){
    	return view('user/BD/pk-Koverall/Solvents')->with('title',"Solvents");
    }
    public function Radicals(){
    	return view('user/BD/pk-Koverall/Radicals')->with('title',"Radicals");    	
    }
    public function References(){
    	return view('user/BD/pk-Koverall/References')->with('title',"References");    	
    }
    public function PK_s(){
    	return view('user/BD/pk-Koverall/PK_s')->with('title',"PK' s");
    }
    public function K_overall(){
    	return view('user/BD/pk-Koverall/K_overall')->with('title',"K overall");
    }
    public function DB_pk_Koverall(){
    	return view('user/BD/pk-Koverall')->with('title',"DB pk Koverall");
    }
}
