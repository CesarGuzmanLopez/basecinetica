<?php

namespace App\Http\Controllers\ABC_DATABASE;

use Illuminate\Http\Request;
use App\q_db_references;
use App\Http\Controllers\Controller;

class ReferencesTable extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return q_db_references::get();
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
    	if( !$request->has('Reference')  ){
    		return ("empty Reference");
    	}
    	$Reference = new q_db_references;
    	$Reference->Coments =$request->Coments;
    	$Reference->Reference= $request->Reference;
    	$Reference->save();
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
    	$Reference = q_db_references::find($id);
    	if( !$request->has('Reference')  ){
    		return ("empty Reference");
    	}
    	$Reference->Coments =$request->Coments;
    	$Reference->Reference= $request->Reference;
    	$Reference->save();	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$Reference = q_db_references::find($id);
    	$Reference->delete();
    }
}
