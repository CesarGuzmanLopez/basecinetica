@extends('home')
@section('userCont')
<div id="up_app"> 
    <div class="row m-4">
  
     <b-form-input
        class="col-7 col-xl-4"
        v-model="filter"
        type="search"
        id="filterInput"
        placeholder="Type to Search"
      ></b-form-input>
    
        <b-button class="col-2 col-xl-1 mx-4" :disabled="!filter" @click="filter = ''"> Clear </b-button>
 
    <b-col  lg="12" xl="6" md="12" class="my-1">
        <b-form-group
          label-align-sm="right"
          label-size="sm"
  
          class="mb-0">
          <b-form-checkbox-group v-model="filterOn" class="mt-1">
            <b class="pr-2">Filter</b>
            <b-form-checkbox value="Name">application </b-form-checkbox>
            <b-form-checkbox value="Version">Version</b-form-checkbox>
            <b-form-checkbox value="Description">Description</b-form-checkbox>
            <b-button v-b-modal.addapp class="fa fa-save bg-success mx-4"> Add application </b-button>
          </b-form-checkbox-group>
        </b-form-group>
      </b-col> 
    
    </div>
    <b-table
      show-empty
      small
      responsive="sm"  
      hover small
      :items="items"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
       :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      :sort-direction="sortDirection"
      @filtered="onFiltered"
      :busy="isBusy"
    >
      <template v-slot:table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
      <template v-slot:cell(Name)="row">
        <?="{{ row.value }}"?> 
      </template>
      <template v-slot:cell(actions)="row">
        <b-button size="sm"  class="fa fa-trash   bg-danger  mr-1"  @click="Delete_id(row.item)"> <span class="text-info"> Delete </span></b-button>
        <b-button size="sm"  class="fa fa-refresh bg-warning mr-1" @click="editmodal(row.item)"> <span class="text-info"> Edit </span> </b-button>
      </template>
      <template v-slot:cell(Location_name)="row">
      		<a :href="'./files/Apps/'+row.item.ID_app+'/'+row.value  " :download="'App_'+row.value" ><?= "{{row.value}}" ?></a>
      </template>
      	
    </b-table> 
      <b-col sm="7" md="12" class="my-1">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          align="fill"
          size="sm"
          class="my-0"
        >
        </b-pagination>
     <br/> 
	</b-col>
     
    <b-modal ref="addapp" id="addapp" title="Add application "   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <label  for="formNewnapp.Name_app" >application Name</label>
             <b-input
               id="formNewnapp.Name"
               v-model="formNewnapp.Name_app"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="application Name"
               name="Name_app"
             ></b-input>
             <label  for="formNewnapp.Version">Version</label>
             <b-input-group class="mb-2 mr-sm-2 mb-sm-0">
               <b-input id="formNewnapp.Version" v-model="formNewnapp.Version" ></b-input>
        		     	
             </b-input-group>
             <label  for="Enable">Enable</label>
                <b-form-checkbox
                      id="Enable"
                      v-model="formNewnapp.Enable"
                      name="formNewnapp.Enable"
                      value="true"
                      unchecked-value="false"
                    >
                      
                    </b-form-checkbox>
          
                 <b-col sm="2"class="mt-4">
               <label for="formNewnapp.Description">Description</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formNewnapp.Description"
                 v-model="formNewnapp.Description"
                 size="sm"
                 placeholder="Description"
             ></b-form-textarea>
             </b-col>
         </b-row>
         <b-row>
             <div class="border border-info col-12 mt-4">
                 <label for="formNewnapp.imageapp" class="p-1"
                 >Application exe</label>
                 <input class="p-3" type="file" ref="form_exe" v-on:change="handleFileUpload()" id="form_exe" name="form_exe"  accept="">
             </div>
         </b-row>  
       </form> 
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa-save m-3  p-2 col-3 bg-success mx-4" @click = "add_App()" >Add application </b-button>
        <b-button  block @click="$bvModal.hide('addapp')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal> 


    <b-modal ref="updateapp" id="updateapp" title="Update application "   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <div class="border border-info col-12 mt-4 p-4">ID:<?="{{formodifi.ID_app}}"?> </div> 
             <p><label  for="formodifi.Name_app" class="p-2">Application Name</label></p>
             <b-input
               id="formodifi.Name_app"
               v-model="formodifi.Name_app"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="application Name"
               name="app name"
             ></b-input>
             <label  for="formodifi.Version">Version</label>
             <b-input-group class="mb-2 mr-sm-2 mb-sm-0">
               <b-input id="formodifi.Version" v-model="formodifi.Version" placeholder="Version"></b-input>
             </b-input-group>
           <label  for="Enable">Enable</label>
                <b-form-checkbox
                      id="formodifi.Enable"
                      v-model="formodifi.Enable"
                      name="formodifi.Enable"
                      value="true"
                      unchecked-value="false"
                    > 
                    </b-form-checkbox> 
                 <b-col sm="2"class="mt-4">
               <label for="formodifi.Description" >Description</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formodifi.Description"
                 v-model="formodifi.Description"
                 size="sm"
                 placeholder="Description"
             ></b-form-textarea> 
         </b-row>
         <b-row>
             <div class="border border-info col-12 mt-4">
                 <label for="formodifi.imageapp" class="p-1"
                 >Application exe</label>
                  <input class="p-3" type="file" ref="form_exe_UP" v-on:change="handleFileUploadUP()" id="add_App " name="form_exe"  accept="">
             </div>
         </b-row>  
       </form>
       
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa fa-refresh m-3  p-2 col-3 bg-success mx-4" @click = "updateApp" >Edit application </b-button>
        <b-button  block @click="$bvModal.hide('updateapp')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal> 
</div> 
@endsection