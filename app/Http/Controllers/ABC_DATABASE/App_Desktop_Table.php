<?php

namespace App\Http\Controllers\ABC_DATABASE;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use App\desktop_apps;
use App\Http\Controllers\Controller;

class App_Desktop_Table extends Controller
{
   
    public function index()
    {
        return desktop_apps::get();
    }

  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->has('Name_app') && $request->hasFile('app_EXE')   )
            return ("empty name or file");
        
        $nombre = "";
        $file="";
        $id=-1;
        
        if($request->hasFile('app_EXE')  ){
            $file = $request->file('app_EXE');
            $nombre = $file->getClientOriginalName();
        }
        $app =  new desktop_apps;
        $app->Name_app =$request->Name_app ;
        $app->Location_name = $nombre; 
        $app->Enable = $request->Enable=="true";
        
        if($request->has('Description')) 
             $app->Description= $request->Description;
        else $app->Description="";
        if($request->has('Version'))
            $app->Version= $request->Version;
         else $app->Version="";
        $app->save();
        $id  = $app->ID_app;
        
        if (!file_exists(public_path("files/Apps/$id"))) {
            mkdir(public_path("files/Apps/$id"), 0777, true);
        }
        if ($request->hasFile('app_EXE') && $request->file('app_EXE')->isValid() ) {
            Storage::disk('public')->put($nombre,  File::get($file));
            
            //return storage_path("app/public/$nombre"). public_path("files/data-base-img/$id/$nombre");
            File::move(storage_path("app/public/$nombre"), public_path("files/Apps/$id/$nombre"));
        }
        return $app->getDateFormat(); 
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
        $app = new desktop_apps();
        $app = desktop_apps::find($id);
        if(!$request->has('Name_app')  ){
            return ("empty name or file");
        } 
        $nombre = "";
        $file=""; 
        if($request->has('Description'))
            $app->Description= $request->Description;
        else $app->Description="";
         if($request->has('Version'))
                $app->Version= $request->Version; 
       
        if($request->hasFile('app_EXE')  ){
            $file = $request->file('app_EXE');
            $nombre = $file->getClientOriginalName();
            $app->Location_name = $nombre;         
        }
        $app->Name_app = $request->Name_app;
        $app->Enable = $request->Enable=="true";
        if($request->has('Description')) $app->Description= $request->Description;
        $app->save();
        
        
        if($nombre!=""){
            if (!file_exists(public_path("files/Apps/$id"))) {
                mkdir(public_path("files/Apps/$id"), 0777, true);
            }
            if ($request->hasFile('app_EXE') && $request->file('app_EXE')->isValid() ) {
                Storage::disk('public')->put($nombre,  File::get($file));
                
                //return storage_path("app/public/$nombre"). public_path("files/data-base-img/$id/$nombre");
                File::move(storage_path("app/public/$nombre"), public_path("files/Apps/$id/$nombre"));
            }
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
        if (file_exists(public_path("files/Apps/$id"))) { 
            unlink(public_path("files/Apps/$id"));
        }
        $mol = desktop_apps::find($id);
        $mol->delete();
    }
}
