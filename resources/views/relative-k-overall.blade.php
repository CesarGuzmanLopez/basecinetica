@extends('layouts.app')
@section('content')
  <div id="aux"></div>
  <div class="cover-container d-flex col-md-11 px-md-4  p-0 col-12  m-0 p-0 mx-auto flex-column justify  ">
    <div id="BaseDatos" class="col-12 p-0 pt-4">
     <div id="compare_kO">

        <h1 class=" bg-white p-2 " >Relative kinetic effectiveness of compounds</h1>
    	<div class="bg-white p-2 mb-2">
    		<form>

    			<div class="row p-2">
    				<div class="col-4"><div class="row"><div class="col-12 col-md-6"><label>Reference component</label></div><div class="col-12 col-md-4">
    				<select  class="form-control" @change="changeMol()"  v-model="MolSelected">
                      <option v-for="option in Molecules" v-bind:value="option.ID">
                       <?="  {{ option.Name }}"?>
                      </option>
					</select>

    				</div></div></div>
    				<div class="col-3"><div class="row"><div class="col-12 col-md-6"><label>Reference Radical  </label></div><div class="col-12 col-md-4">

 					 <select  class="form-control " @change="changeRad()"  v-model="RadSelected">
                      <option v-for="option in ActSRad" v-bind:value="option.ID_Radical">
                       <?="  {{ option.Name_Radical }}"?>
                      </option>
					 </select>
    				</div></div></div>


    				<div class="col-3"><div class="row"><div class="col-12 col-md-6"><label>Reference Solvent  </label></div><div class="col-12 col-md-4">
						<select  class="form-control " @change="changeSol()" v-model="SolSelected">
                          <option v-for="option in ActSolv" v-bind:value="option.ID_Solvent">
                           <?="  {{ option.Name_Solvent }}"?>
                          </option>
						</select>
					</div></div></div>

    				<div class="col-2"><div class="row"><div class="col-12 col-md-4"><label>pH  </label></div><div class="col-12 col-md-8">
						<select  class="form-control " @change="changepH()" v-model="pH_Selected">
                          <option v-for="option in Act_pH" v-bind:value="option.pH">
                          	<template v-if = "parseFloat(option.pH) > 0" >
                           		<?="  {{ option.pH }}"?>
                          	</template>
                          	<template v-else>
                          		whithout
                          	</template>
                          </option>
						</select>
					</div></div></div>

    			</div>
    			<div class="row p-2">

    			<div class="col-md-2 col-6" ><input type="radio" name="type_e" value="All" v-model="TypSelected" @change="changepH()"> All</div>
    			<div class="col-md-2 col-6"><input type="radio" name="type_e" value="Exp" v-model="TypSelected"@change="changepH()" > Experimental</div>
    			<div class="col-md-3 col-6"><input type="radio" name="type_e"  value="Theo. with f_M" v-model="TypSelected" @change="changepH()" > Theoretical with fraction molar</div>
    		    <div class="col-md-3 col-6"><input type="radio" name="type_e"  value="Theo. without f_M" v-model="TypSelected" @change="changepH()" > Theoretical without fraction molar </div>

    			</div>

    		</form>
    	</div>
    	<div class="">

    	<div class="table-responsive bg-white p-2 ">
		<div class="row p-4 ">
		   	<div class="col-md-8 ">
				<h1 class="">Click target</h1>
			</div>
			<div class="col-md-4">
            	<div v-if ="(IDK_OveralComparation!=-1)">
					<b-button  block class="fa fa-balance-scale"  size="lg" v-b-modal.modal_compare> <span class="text-white"> Compare </span></b-button>
				</div>
			</div>
		</div>
   		<!-- inicia la tabla -->
    	    <b-table
              show-empty
              small


              responsive="sm"
              striped
              hover small
              :items="items"
              :fields="fields"
              :current-page="currentPage"
              :per-page="perPage"
              :filter="filter"
              @row-clicked="RowClicked"
              :sort-by.sync="sortBy"
              :sort-desc.sync="sortDesc"
              :sort-direction="sortDirection"
              @filtered="onFiltered"
              :busy="isBusy"
               :tbody-tr-class="rowClass"
            >

           	<template v-slot:cell(Valor)="row" >
       			<div  ><?=" {{ row.value.toPrecision(2) }}"?> </div>
      		</template>
            <template v-slot:cell(Relation)="row" >
            	<div v-if ="(IDK_OveralComparation!=-1)">

       				<div ><?=" {{ (row.item.Valor/ValorCompare).toFixed(2) }}"?>  </div>
       				<template v-if=" (row.item.Valor/ValorCompare)!=1 " >
       				times

    	   			</template>
      			</div>
      		</template>

      	  <template v-slot:row-details="row">
                <b-card >
                  	<b-form-textarea
                        rows="6"
                        max-rows="10"
                        :value='row.item.RIS'>
                       <?="{{ row.item.RIS }}"?>
                      </b-form-textarea>
                    </b-card>
          </template>
      		<template v-slot:cell(info)="row" >
                <b-button size="sm" @click="row.toggleDetails" class="fa fa-file-text ">
               <?="   {{ row.detailsShowing ? 'Hide' : 'Show' }} RIS"?>
                </b-button>
      		</template>
		    </b-table>
    	<!-- fin tabla -->
    <b-col sm="7" md="12" class="my-1">
      <b-pagination
       v-model="currentPage"
       :total-rows="totalRows"
       :per-page="perPage"
       align="fill"
       size="sm"
       class="my-0"
      ></b-pagination>
      <br/>
 	  <b-modal id="modal_compare" title="Compare" hide-footer  size="xl" >

			<div class="row">

    		<div class="col-3" ><b>Molecule:</b> <?="{{molToCompare.Name}}"?></div>

        		<template v-if = "parseFloat(molToCompare.pH) > 0" >

        		<div class="col-3">
            		<b>	pH:</b>  <?="{{molToCompare.pH}} " ?>
        		</div>
        		</template>
        		<div class="col-3">
        			<b>Radical:</b> <?="{{molToCompare.Name_Radical}} " ?>
        		</div>
        		<div class="col-3">
        			<b>Solvent:</b> <?="{{molToCompare.Name_Solvent}} " ?>
        		</div>
        	</div>
        	<div class="row mt-3">
    		<div class="col-3">
    		<template v-if="molToCompare.Valor>0">
    	 		<h4 class="pt-2"><b>k Overall:</b> <?="{{molToCompare.Valor.toPrecision(2)}}"?></h4>
    		</template>
    		</div>
    		<div class="col-4 ">
    		<div class="row p-2">
    			<div class="col-4 pt-2">Molecule</div> <div class="col-8"><input class="form-control form-control-lg" type="text" placeholder="Name" v-model="userMol"></div>
    		</div>
    		</div>
    		<div class="col-4 " >
    			<div class="row p-2">
    			<div class="col-5 pt-2">K Overrall </div> <div class="col-7"><input class="form-control form-control-lg" type="text" placeholder="Value" v-model="userValue" ></div>
    			</div>
    		</div>

    		</div>

    	   <div class="row">
    	   	<div class="col-8 offset-2  pt-4">
    	   		<template v-if="parseFloat( ' '+userValue)> 0">
    	   			<h2>Ratio: <?=" {{ (parseFloat( userValue)/(ValorCompare*1.0)).toFixed(4) }}"?> times

    	   			</h2>
    	   		</template>
    	   	</div>
    	   </div>
	 </b-modal>
    </b-col>
    	</div>

     	</div>
     </div>
    </div>
   </div>
@endsection
