<?php

namespace App\Http\Controllers\ABC_DATABASE;

use Illuminate\Http\Request;
use App\q_db_k_overalls;
use App\User;
use App\Http\Controllers\Controller;

class K_overalsTable extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
    	$koverralls = new  q_db_k_overalls;
    	Return $koverralls
    	->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
    	->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
    	->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent') 
    	->leftjoin('q_db_references' ,'q_db_k_overalls.id_reference','=','q_db_references.id_reference')
		->select('*')->get();
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
    	
    	$koverralls = new q_db_k_overalls;
    	
    	$koverralls->ID_Alta=auth()->id();

    	if($request->has('Descripcion') && $request->Descripcion!="" && $request->Descripcion!="null"  )
    		$koverralls->Descripcion=$request->Descripcion;
    	
    	$koverralls->ID_Molecule=0+$request->Id_Molecule;
    
    	if($request->has('Reference') && $request->Reference!="-1"&&$request->Reference!=-1 && $request->Reference!="null" )	
    		$koverralls->id_reference=0+$request->Reference;
    		
    		
    	$koverralls->Tipo=$request->Tipo;

    	if($request->has('Radical') && $request->Radical!="-1"&&$request->Radical!=-1  &&$request->Radical!="null")
    		$koverralls->radical=0+$request->Radical;
    	
    	if($request->has('Solvent') && $request->Solvent!="-1"&&$request->Solvent!=-1 &&$request->Solvent!="null")
    		$koverralls->Solvent=0+$request->Solvent;
    		
    	if($request->has('pH')  &&$request->pH!="null" )
    		$koverralls->pH=$request->pH;
    	
    	if($request->has('Valor') && $request->Valor!="" &&$request->Valor!="null" )
    		$koverralls->Valor=0+$request->Valor;
    		    		
    	$koverralls->save();
 
    }
    private function limpia($value){
    	
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
    	$koverralls = q_db_k_overalls::find($id);
    	
    	$koverralls->ID_Alta=auth()->id();
    	
    	if($request->has('Descripcion') && $request->Descripcion!="" && $request->Descripcion!="null"  )
    		$koverralls->Descripcion=$request->Descripcion;
    		
    		$koverralls->ID_Molecule=0+$request->Id_Molecule;
    		
    		if($request->has('Reference') && $request->Reference!="-1"&&$request->Reference!=-1 && $request->Reference!="null" )
    			$koverralls->id_reference=0+$request->Reference;			
    		$koverralls->Tipo=$request->Tipo;
    			
    		if($request->has('Radical') && $request->Radical!="-1"&&$request->Radical!=-1  &&$request->Radical!="null")
    			$koverralls->radical=0+$request->Radical;
    				
  			if($request->has('Solvent') && $request->Solvent!="-1"&&$request->Solvent!=-1 &&$request->Solvent!="null")
   				$koverralls->Solvent=0+$request->Solvent;
    					
   			if($request->has('pH')   &&$request->pH!="null" )
				$koverralls->pH=$request->pH;
    						
   			if($request->has('Valor') && $request->Valor!="" &&$request->Valor!="null" )
    			$koverralls->Valor=0+$request->Valor;
    							
    		$koverralls->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$koverralls = q_db_k_overalls::find($id);
    	$koverralls->delete();
    }
}