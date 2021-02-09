<?php

namespace App\Http\Controllers\ABC_DATABASE;

use Illuminate\Http\Request;
use App\q_db_pks;
use App\Http\Controllers\Controller;

class PK_sTable extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$pKa = new   q_db_pks ;
    	Return $pKa
    	->leftjoin('q_db_molecules','q_db_pks.ID', '=',  'q_db_molecules.ID')
    	->leftjoin('q_db_references' ,'q_db_pks.id_reference','=','q_db_references.id_reference')
    	->select('q_db_pks.*','q_db_molecules.Name as Name','q_db_molecules.RIS as RIS'  ,'q_db_molecules.Imagen as Imagen','q_db_references.*')->get();
    
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
    	$pKa = new q_db_pks;
    	$pKa->ID_Alta=auth()->id();
    	$pKa->ID =0+ $request->Id_Molecule;
    	if($request->has('Site') && $request->Site!="" &&$request->Site!="null" )
    		$pKa->Site=$request->Site;
    	
    	if($request->has('Description') && $request->Description!="" &&$request->Description!="null" )
    		$pKa->Description=$request->Description;
    	if($request->has('id_reference') && $request->id_reference!="" &&$request->id_reference!="null" )
    		$pKa->id_reference =$request->Reference;
    	if($request->has('Value') && $request->Value!="" &&$request->Value!="null" )
    		$pKa->Value= 0+$request->Value;
	    if($request->has('Type') && $request->Type!="" &&$request->Type!="null" )	
    		$pKa->Tipo_Exp_teo= $request->Type;
		
    	$pKa->save();	
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
    	$pKa = q_db_pks::find($id);
    	
    	
    	$pKa->ID_Alta=auth()->id();
    	$pKa->ID =0+ $request->Id_Molecule;
    	if($request->has('Site')   &&$request->Site!="null" )
    		$pKa->Site=$request->Site;
     	$pKa->Description=$request->Description;
 		if($request->has('id_reference') && $request->id_reference!="" &&$request->id_reference!="null" )
    		$pKa->id_reference =$request->Reference;
		if($request->has('Value') && $request->Value!="" &&$request->Value!="null" )
    		$pKa->Value= 0+$request->Value;
    	if($request->has('Type') && $request->Type!="" &&$request->Type!="null" )
    		$pKa->Tipo_Exp_teo= $request->Type;
    						
    	$pKa->save();
    	
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$pKa = q_db_pks::find($id);
    	$pKa->delete();
    }
}
