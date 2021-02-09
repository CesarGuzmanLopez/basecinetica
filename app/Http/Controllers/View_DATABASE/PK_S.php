<?php

namespace App\Http\Controllers\View_DATABASE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\q_db_pks;

class PK_S extends Controller
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
    
    public function show($id)
    {
    	$pKa = new   q_db_pks ;
    	Return $pKa
    	->leftjoin('q_db_molecules','q_db_pks.ID', '=',  'q_db_molecules.ID')
    	->leftjoin('q_db_references' ,'q_db_pks.id_reference','=','q_db_references.id_reference')->where('q_db_pks.ID',$id)
    	->select('q_db_pks.*','q_db_molecules.Name as Name','q_db_molecules.RIS as RIS'  ,'q_db_molecules.Imagen as Imagen','q_db_references.*')
    	->orderBy('Value','ASC')->get();     	
    }

   
}
