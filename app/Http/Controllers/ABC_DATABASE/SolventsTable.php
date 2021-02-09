<?php

namespace App\Http\Controllers\ABC_DATABASE;

use Illuminate\Http\Request;
use App\q_db_solvents;
use App\Http\Controllers\Controller;

class SolventsTable extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	return q_db_solvents::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	if( !$request->has('Name_Solvent')  ){
    		return ("empty Name");
    	}	   
    	$solvent = new q_db_solvents;
    	$solvent->Description =$request->Description;
    	$solvent->Name_Solvent= $request->Name_Solvent;
    	$solvent->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    	$solvent = q_db_solvents::find($id);
    	if( !$request->has('Name_Solvent')  ){
    		return ("empty Name");
    	}
    	$solvent->Description =$request->Description;
    	$solvent->Name_Solvent= $request->Name_Solvent;
    	$solvent->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$solvent = q_db_solvents::find($id);
    	$solvent->delete();
    }
}
