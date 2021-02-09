<?php

namespace App\Http\Controllers\ABC_DATABASE;

use Illuminate\Http\Request;
use App\q_db_radicals;
use App\Http\Controllers\Controller;

class RadicalsTable extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return q_db_radicals::get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	if( !$request->has('Name_Radical')  ){
    		return ("empty Name");
    	}
    	$radical = new q_db_radicals;
    	$radical->Description =$request->Description;
    	$radical->Name_radical= $request->Name_Radical;
    	$radical->save();
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
    	$radical = q_db_radicals::find($id);
    	if( !$request->has('Name_Radical')  ){
    		return ("empty Name");
    	}
    	$radical->Description =$request->Description;
    	$radical->Name_radical= $request->Name_Radical;
    	$radical->save();
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$radical = q_db_radicals::find($id);
    	$radical->delete();
    }
}
