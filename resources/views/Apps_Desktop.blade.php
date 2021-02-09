<?php
use App\desktop_apps;

function FileSizeConvert($bytes)
{
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );
    
    foreach($arBytes as $arItem)
    {
        if($bytes >= $arItem["VALUE"])
        {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        }
    }
    return $result;
}




$Apps = desktop_apps::get();
$app = new desktop_apps;
  $app->Location_name;
?>
@extends('layouts.app') 
@section('content') 
<div id="aux"> 
	<div class="bg-white px-4 mx-5 ">
		<h1>Desktop applications</h1>
	</div>
@foreach ($Apps as $app)
  	@if($app->Enable) 
    <div class="p-4 m-4">
      <b-card title="{{$app->Name_app}}" sub-title="Ver {{$app->Version}}  ">
        <b>size  {{FileSizeConvert(filesize ( public_path('files/Apps/'.$app->ID_app.'/'.$app->Location_name))  )}}</b>
       
        <b-card-text>
          	 {{$app->Description}} 
        </b-card-text> 
        <a href="{{url('files/Apps/'.$app->ID_app.'/'.$app->Location_name)}}" class="card-link">Get {{$app->Name_app}}</a>
       	</b-card>
    </div>


   	@endif
@endforeach
</div>
@endsection

