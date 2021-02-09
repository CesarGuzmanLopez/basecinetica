<?php

namespace App\Http\Controllers\View_DATABASE;

use App\q_db_molecules;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MoleculesController extends Controller
{

    public function index()
    {
    	$molecules = new q_db_molecules;
    	return $molecules->select("*")->get();
    }
 
    public function show($id)
    {
        //
    }
 
 
}
