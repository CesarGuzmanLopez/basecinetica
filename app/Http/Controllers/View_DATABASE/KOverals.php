<?php

namespace App\Http\Controllers\View_DATABASE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\q_db_k_overalls;

class KOverals extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$koverralls = new  q_db_k_overalls;
    	Return $koverralls
    	->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
    	->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
    	->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent')
    	->leftjoin('q_db_references' ,'q_db_k_overalls.id_reference','=','q_db_references.id_reference')
    	->where('q_db_k_overalls.ID_Molecule',$id)
    	->select('*')->get();
    }

 
 
}
