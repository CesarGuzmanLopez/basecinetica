<?php

namespace App\Http\Controllers\ABC_DATABASE;

use App\q_db_molecules;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MoleculeTable extends Controller
{
	public function __constructo(){

		$this->middleware(['auth','role:admin,super-admin']);

	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
    	return q_db_molecules::get();

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
    	if(!$request->has('SMILE') || !$request->has('Name')  ){
    		return ("empty name or smile");
    	}
    	$nombre = "";
    	$file="";
    	$id=-1;
    	if($request->hasFile('Image')  ){
    		$file = $request->file('Image');
    		$nombre = $file->getClientOriginalName();
    	}

    	$mole = new q_db_molecules;

    	$mole->Name =$request->Name;
    	$mole->Imagen=$nombre;
    	$mole->Active='true';
    	$mole->SMILE=$request->SMILE;
    	if($request->has('RIS')) $mole->RIS=$request->RIS;
    	else $mole->RIS="";
    	if($request->has('Description')) $mole->Description= $request->Description;
    	else $mole->Description="";



    	$mole->save();

    	$id=$mole->ID;

    	if (!file_exists(public_path("files/data-base-img/$id"))) {
    		mkdir(public_path("files/data-base-img/$id"), 0777, true);
    	}

    	if ($request->hasFile('Image') && $request->file('Image')->isValid() ) {
    		Storage::disk('public')->put($nombre,  File::get($file));

    		//return storage_path("app/public/$nombre"). public_path("files/data-base-img/$id/$nombre");
    		File::move(storage_path("app/public/$nombre"), public_path("files/data-base-img/$id/$nombre"));
    	}
    	return $mole->getDateFormat();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    public function update(Request $request,$id )
    {
    	$mole= q_db_molecules::find($id);
     	if(!$request->has('SMILE') || !$request->has('Name')  ){
    		return ("empty name or smile");
    	}
    	$nombre = "";
    	$file="";
    	$id=-1;
    	if($request->hasFile('Image')  ){
    		$file = $request->file('Image');
    		$nombre = $file->getClientOriginalName();
    	}
    	$mole->Name =$request->Name;
    	if($nombre!="")$mole->Imagen=$nombre;

    	$mole->Active='true';
    	$mole->SMILE=$request->SMILE;
    	if($request->has('RIS')) $mole->RIS=$request->RIS;
    	if($request->has('Description')) $mole->Description= $request->Description;
    	$mole->save();
    	$id=$mole->ID;

    	if (!file_exists(public_path("files/data-base-img/$id"))) {
    		mkdir(public_path("files/data-base-img/$id"), 0777, true);
    	}

    	if ($request->hasFile('Image') && $request->file('Image')->isValid() ) {
    		Storage::disk('public')->put($nombre,  File::get($file));

    		//return storage_path("app/public/$nombre"). public_path("files/data-base-img/$id/$nombre");
    		File::move(storage_path("app/public/$nombre"), public_path("files/data-base-img/$id/$nombre"));
    	}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "no funciona";
        try{
    	if (!file_exists(public_path("files/data-base-img/$id"))) {
    		unlink(public_path("files/data-base-img/$id"), 0777, true);
    	}
        }catch (Exception $e) {
          echo("Error al eliminar el archivo");
        }finally {
    	$mol = q_db_molecules::find($id);
        $mol->delete();
        }
    }
}
