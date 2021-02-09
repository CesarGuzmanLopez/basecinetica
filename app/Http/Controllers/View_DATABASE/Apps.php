<?php

namespace App\Http\Controllers\View_DATABASE;

use App\Http\Controllers\Controller;
 use App\desktop_apps;

class Apps extends Controller{
    public function index(){
        $apps = new  desktop_apps;
        Return $apps->get();
    }
 
    public function show($id){
        $app = new  desktop_apps;
    	Return $app->where('ID_app',$id)
    	->select('*')->get();
    }
}
