@extends('layouts.app') 
@section('content')   
  <div class="cover-container d-flex col-md-11 px-md-4  p-0 col-12  m-0 p-0 mx-auto flex-column justify  ">
    <div id="BaseDatos" class="col-12 p-0 pt-4"> 
             <h1 class=" bg-white p-0 " >Molecular Properties Database</h1>
              <div id="aux">
               <tablamodelo></tablamodelo>
      	      </div>
      	      
      <!-- fin table de moleculas --> 
    </div>
   </div>
@endsection