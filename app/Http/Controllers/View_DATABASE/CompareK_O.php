<?php

namespace App\Http\Controllers\View_DATABASE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\q_db_k_overalls;


class CompareK_O extends Controller
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


    /*
     * Tengo que pedir Componente, Radical y solvente
     *
     *
     * */
    public function show($id)
    {



    /*
        $koverralls = new  q_db_k_overalls;
        Return $koverralls
        ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
        ->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
        ->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent')
        ->leftjoin('q_db_references' ,'q_db_k_overalls.id_reference','=','q_db_references.id_reference')
        ->where('q_db_k_overalls.ID_Molecule',$id)
        ->select('*')->get();
    */
    }

    public function store(Request $request){

        $VarTable =NULL ;

        $pH=null;
        $koverralls = new  q_db_k_overalls;


        switch($request->appeal){
            case "Const":
                $Type = ($request->Type =="All" )?"": $request->Type ;

                $pH = ($request->pH <0 ||$request->pH ==""||  $request->pH ==null )?"":$request->pH;
                $VarTable =  $koverralls
                ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
                ->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
                ->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent')
                ->where('q_db_k_overalls.Tipo','Like','%'.$Type.'%')
                ->where('q_db_k_overalls.Solvent','=',$request->IDSolvent)
                ->where('q_db_k_overalls.radical','=',$request->IDRadical)
                ->where(
                        function ($VarTable)use ($pH){
                           if($pH!="")
                               $VarTable = $VarTable->where('q_db_k_overalls.pH','=',$pH);
                            else
                               $VarTable= $VarTable->WhereNull('pH');
                            return $VarTable;
                        }
                    )
                 ->orderBy('q_db_k_overalls.Valor');

                 if(($VarTable->where('q_db_k_overalls.ID_Molecule','=',$request->IDMolecule)->get()->isEmpty()))
                     $VarTable ="[]";
                     else{

                         $VarTable =  $koverralls
                         ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
                         ->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
                         ->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent')
                         ->where('q_db_k_overalls.Tipo','Like','%'.$Type.'%')
                         ->where('q_db_k_overalls.Solvent','=',$request->IDSolvent)
                         ->where('q_db_k_overalls.radical','=',$request->IDRadical)
                         ->where(
                             function ($VarTable)use ($pH){
                                 if($pH!="")
                                     $VarTable = $VarTable->where('q_db_k_overalls.pH','=',$pH);
                                     else
                                         $VarTable= $VarTable->WhereNull('pH');
                                         return $VarTable;
                             }
                             )
                             ->orderBy('q_db_k_overalls.Valor')->get();
                     }


                /*
                if($pH=="")
                    $VarTable = $VarTable->WhereNull('pH')  ->orderBy('q_db_k_overalls.Valor')->select('*')->get();
                else
                    $VarTable = $VarTable->select('*')  ->orderBy('q_db_k_overalls.Valor')->get();

                */
                break;

            case "Radicals":
                $VarTable =  $koverralls
                ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
                ->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
                ->select('q_db_molecules.Name')
                ->where('q_db_k_overalls.ID_Molecule','=',$request->IDMolecule)
                ->addSelect('q_db_radicals.ID_Radical')
                ->addSelect('q_db_radicals.Name_Radical')
                ->distinct('q_db_radicals.Name_Radical')
                ->get();

                break;
            case "Solvents":
                $VarTable =  $koverralls
                ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
                ->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
                ->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent')
                ->where('q_db_k_overalls.ID_Molecule','=',$request->IDMolecule)
                ->where('q_db_k_overalls.radical','=',$request->IDRadical)
                ->select('q_db_molecules.Name')
                ->addselect('q_db_solvents.ID_Solvent')
                ->addselect('q_db_solvents.Name_Solvent')
                ->addSelect('q_db_radicals.ID_Radical')
                ->addSelect('q_db_radicals.Name_Radical')
                ->addSelect('q_db_molecules.ID')
                ->distinct('q_db_solvents.Name_Solvent')
                ->get();
                break;

            case "Molecules":
                $VarTable =  $koverralls
                ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
                ->select('q_db_molecules.Name')
                ->addSelect('q_db_molecules.ID')->distinct('ID_Molecule')->get();
                 break;
            case "pH":
                $VarTable =  $koverralls
                ->leftjoin('q_db_molecules','q_db_k_overalls.ID_Molecule', '=',  'q_db_molecules.ID')
                ->leftjoin('q_db_radicals' ,'q_db_k_overalls.radical','=','q_db_radicals.ID_Radical')
                ->leftjoin('q_db_solvents' ,'q_db_k_overalls.Solvent','=','q_db_solvents.ID_Solvent')
                ->where('q_db_k_overalls.ID_Molecule','=',$request->IDMolecule)
                ->where('q_db_k_overalls.Solvent','=',$request->IDSolvent)
                ->where('q_db_k_overalls.radical','=',$request->IDRadical)
                ->select('q_db_molecules.Name')
                ->addselect('q_db_solvents.ID_Solvent')
                ->addselect('q_db_solvents.Name_Solvent')
                ->addSelect('q_db_radicals.ID_Radical')
                ->addSelect('q_db_radicals.Name_Radical')
                ->addSelect('q_db_molecules.ID')
                ->addSelect('q_db_k_overalls.pH')
                ->distinct('q_db_solvents.Name_Solvent')

                ->get();
                break;
            default:
                 break;
        }
        return $VarTable;
    }

}
