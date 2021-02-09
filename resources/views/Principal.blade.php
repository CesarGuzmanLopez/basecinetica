@extends('layouts.app')
<?php 
function CreaTargeta($title, $urlImage, $description,$go, $link){?>
	
	<b-card no-body  lg class="p-3 m-4">
		<div class="row">
            <? if($urlImage != ""){?>
			<div  class="col-12 col-md-4 p-md-1 p-5 ">
			   <b-img src="<?=$urlImage?>" fluid alt="Fluid image"></b-img>
			</div>
            <? }?>
			<div class="col-12 col-md-8 px-3">
				<div class="card-block px-3">
					<h4 class="card-title"><?=$title?></h4>
					 <b-card-text><?=$description?></b-card-text>
						<a href="<?=$link?>" class="btn btn-dark"><?=$go?></a>
				</div>
			</div> 
			</div>
		</b-card>
 <?php 
};

?>
@section('content') 
<div id="aux">

  <article role="main" id="Presentation" class="  ">
 
    <h1 class="col-12 text-center"> Annia Galano's Group</h1>    
      	
 	<div class="p-4 m1 row cardPrincipal">
 		<div id="i_Databases">
     		<div class="mx-4 p-3 text-info ">
     			<h1>Databases</h1>
     		</div>
     		
        	 <?php CreaTargeta("Star Database",asset('img/Stra_img.jpg'),"STAR is an application and database for astrochemistry. <br>The database holds Thermochemistry theoretical information of the ground state (enthalpy and free energy) for 134 species observed in phase gas (in black) and proposed intermediaries (in gray). Currently, Thermochemistry data is calculated with the CBS-QB3 composite method. The application finds possible bimolecular chemical reactions that have potential to create a molecule in the ISM.","Data Base",url('Star'));?>   		
     		 <?php CreaTargeta("Kinetics Database ",asset('img/Kinetiks_img.jpg'),"Database  for kinetics obtained experimentally or with  theoretical methodologies ","Database",url('Kinetics'));?>  
 		</div>
 		<div>
 		<div id="i_aplications"> 
 			<div class="mx-4 p-3 text-info ">
     			<h1>Web Applications </h1>
     		</div>
 		
         <?php CreaTargeta("Relative kinetic effectiveness of compounds",asset('img/compareK_img.jpg'),"Relative assessment between antioxidants compounds","App",url('Kinetics/relative-k-overall'));?>  
       	</div>
       	<div id="i_aplications"> 
 			<div class="mx-4 p-3 text-info ">
     			<h1>Desktop Applications </h1>
     		</div>
         <?php CreaTargeta("Aplications",asset('img/matrazRoto.png?1'),"Aplicattions for desktop","Get Apps",url('Apps-Desktop'));?>  
       	</div>
       	</div>
       </div>
     <div class="lead text-center">
	      <h3>Dr. Annia Galano</h3><a href="https://www.agalano.com/" class="btn btn-lg btn-secondary">agalano.com</a>
	 </div>
 </article>
</div>
@endsection
