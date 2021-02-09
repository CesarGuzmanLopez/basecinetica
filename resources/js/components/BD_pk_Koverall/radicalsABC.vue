<template>
  <b-container fluid class="bg-white p-2">
    <h1>Tables Radicals.</h1>
    <!-- User Interface controls -->
      <b-col lg="12" class="my-1">
        <b-form-group
          label="Filter"
          label-cols-sm="3"
          label-align-sm="right"
          label-size="sm"
          label-for="filterInput"
          class="mb-0"
        >
          <b-input-group size="sm">
            <b-form-input
              v-model="filter"
              type="search"
              id="filterInput"
              placeholder="Type to Search"
            ></b-form-input>
            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''"> Clear </b-button>
            </b-input-group-append>
           <div>
         <b-button v-b-modal.AddRadical class="fa fa-save bg-success mx-4"> Add Radical</b-button>
         </div>
           </b-input-group>
          
        </b-form-group>
     
      </b-col>



    <!-- Main table element -->
    <b-table
      show-empty
      small
      stacked="md"
      responsive="sm"
      striped 
       hover small
      :items="items"
      :fields="fields"
      :current-page="currentPage"
      :per-page="perPage"
      :filter="filter"
      :filterIncludedFields="filterOn"
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
      <template v-slot:cell(Name_Radical)="row">
        {{ row.value }} 
      </template>

      <template v-slot:cell(actions)="row">
        <b-button size="sm"  class="fa fa-trash   bg-danger  mr-1"  @click="Delete_id(row.item)"> <span class="text-info"> Delete </span></b-button>
        <b-button size="sm"  class="fa fa-refresh bg-warning mr-1" @click="showmodal(row.item)"> <span class="text-info"> Edit </span> </b-button>
    
      </template>      
      <template v-slot:row-details="row">
        <b-card >
          <b-form-textarea
            rows="6"
            max-rows="10"
            :value='row.item.RIS'
          >
         {{ row.item.RIS }}
          </b-form-textarea>
        </b-card>
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
        ></b-pagination>
        <br/> 
      </b-col> 
      <div class="p4 d-flex align-items-end">
          <h1 class="fa fa-exclamation-circle text-success mt-auto p-2  mr-4 ">{{ AddRadicalMensaje}}</h1>
      </div>

    
    <b-modal ref="AddRadical" id="AddRadical" title="Add Radical"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <label  for="formNewnRadical.Name_Radical" >Radical Name</label>
             <b-input
               id="formNewnRadical.Name_Radical"
               v-model="formNewnRadical.Name_Radical"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="Radical Name"
               name="Name_Radical"
             ></b-input>
      
         
                 <b-col sm="2"class="mt-4">
               <label for="formNewnRadical.Description">Description</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formNewnRadical.Description"
                 v-model="formNewnRadical.Description"
                 size="sm"
                 placeholder="Small Description"
             ></b-form-textarea>
             </b-col>
         
         </b-row>
       
       </form>
       
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa-save m-3  p-2 col-3 bg-success mx-4" @click = "AddRadical()" >Add Radical</b-button>
        <b-button  block @click="$bvModal.hide('AddRadical')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal>
   
   
   
    <b-modal ref="updateRadical" id="updateRadical" title="Update Radical"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <div class="border border-info col-12 mt-4 p-4">ID_Radical: {{formodifi.ID_Radical}}</div> 
             <p><label  for="formNewnRadical.Name_Radical" class="p-2">Radical Name</label></p>
             <b-input
               id="formodifi.Name_Radical"
               v-model="formodifi.Name_Radical"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="Radical Name"
               name="Name_Radical"
             ></b-input>
        
         
                 <b-col sm="2"class="mt-4">
               <label for="formodifi.Description">Description</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formodifi.Description"
                 v-model="formodifi.Description"
                 size="sm"
                 placeholder="Small Description"
             ></b-form-textarea>
             </b-col>
         </b-row>  
       </form>
       
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa fa-refresh m-3  p-2 col-3 bg-success mx-4" @click = "updateRadicallcule()" >Edit Radical</b-button>
        <b-button  block @click="$bvModal.hide('updateRadical')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal>
   
   
  </b-container>

</template>

<script>

  export default {
    data() {	
      return {
    	isBusy:true,
    	formNewnRadical: {
    		ID_Radical:'',
    		Name_Radical: '', 
    		Description:'', 
    	},
    	formodifi: {
    		ID_Radical:'',
    		Name_Radical: '', 
    		Description:'', 
    	},
        items: [
          { Active: true, Description: "...", Name_Radical:  'Cargando espere porfavor'},
        ],
        AddRadicalMensaje:'',
        fields: [
          {key:'ID_Radical',label:'id', variant: 'success'},
          { key: 'Name_Radical', label: 'Radical name', sortable: true },
          { key: 'Description', label: 'Description'  },
          { key: 'actions', label: 'Actions' },
        ],
        totalRows: 1,
        currentPage: 1,
        perPage: 15,
        pageOptions: [5, 10, 15],
        sortBy: '',
        sortDesc: false,
        sortDirection: 'asc',
        filter: null,
        filterOn: [],
        
        infoModal: {
          id: '-1',
          title: '',
          content: ''
        },
		data_mole:{
			id:'0',
 			Description:'',
 			Name_Radical: '',
		 
		},
      }
     
      
    } ,

    computed: {
      sortOptions() {
        // Create an options list from our fields
        return this.fields
          .filter(f => f.sortable)
          .map(f => {
            return { text: f.label, value: f.key }
          })
      }
    },
    mounted() {
      // Set the initial number of items
      	this.totalRows = this.items.length
      	axios.get('../../RadicalsTable').then(response =>{
    	this.items = response.data;
    	this.totalRows = this.items.length;
    	this.isBusy= false;
      });
      
    },
    methods: {
  
      resetInfoModal() {
        this.infoModal.title = ''
        this.infoModal.content = ''
      },
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
    
      clearaddmol(){
    	this.formNewnRadical.Name_Radical='';
     	this.formNewnRadical.Description='';
      },
      
      AddRadical(){
 	   var key, count = 0;
  	   if(this.formNewnRadical.Name_Radical===""  ) {
  		  	alert("Name Radical  cannot be empty");
	  	 	this.AddRadicalMensaje= (this.formNewnRadical.Name_Radical)+"Error ";
	  		return 0;
	  	}
  	   

 	   for(key in this.items ) {
 		 if(this.items[key].Name_Radical.toUpperCase() ===this.formNewnRadical.Name_Radical.toUpperCase() ){
 	  		alert("this Radical  Exists");
 	  	 	this.AddRadicalMensaje= (this.formNewnRadical.Name_Radical)+"Error ";
 	  		return 0;
 	  	 }
 	   }
       /* Initialize the form data */
       var formData = new FormData(); 
         
       /*  Add the form data we need to submit */
        formData.append('Name_Radical', this.formNewnRadical.Name_Radical);
        formData.append('Description', this.formNewnRadical.Description);
        
       /* Make the request to the POST ../../RadicalTable URL */
       axios.post( '../../RadicalsTable',formData,{
       headers: { 'Content-Type': 'multipart/form-data'}}
       ).then(response =>{ 
    	   	console.log(response.data);	 
    	   	this.AddRadicalMensaje=  ' _ '+ this.formNewnRadical.Name_Radical +" add successful";
    	     axios.get('../../RadicalsTable').then(response =>{
    	     	this.items = response.data;
    	     	this.totalRows = this.items.length;
    	        });
    	        
       }
       ).catch(function(){ this.AddRadicalMensaje= (this.formNewnRadical.Name_Radical)+"Error ";}); 
       	
  
       this.clearaddmol();
      
       axios.get('../../RadicalsTable').then(response =>{
       	this.items = response.data;
       	this.totalRows = this.items.length;
	   });
       this.$refs['AddRadical'].hide();
      }, 
      loadTextFromFile(ev) {
          const file = ev.target.files[0];
          const reader = new FileReader();
          reader.onload = e => {
        	  this.formodifi.RIS=e.target.result
        	  this.formNewnRadical.RIS =e.target.result};
          reader.readAsText(file);
       },
       Delete_id(index){
    	   
    	        this.$bvModal.msgBoxConfirm('Please confirm that you want to delete "'+index.Name_Radical +'".', {
    	          title: 'Please Confirm',
    	          size: 'sm',
    	          buttonSize: 'sm',
    	          okVariant: 'danger',
    	          okTitle: 'YES',
    	          cancelTitle: 'NO',
    	          footerClass: 'p-2',
    	          hideHeaderClose: false,
    	          centered: true
    	        })
    	        .then(value => {
    	        if(value ===true){
    	           	axios.delete( '../../RadicalsTable/'+index.ID_Radical).then(
    	            response =>{ 
    	               axios.get('../../RadicalsTable').then(response =>{
    	           	      	this.items = response.data;
    	           	       	this.totalRows = this.items.length;
    	           	       	
    	           	   });
 
    	            }).catch(function(){ this.AddRadicalMensaje= (this.formNewnRadical.Name_Radical)+"Error ";}); 
    	            	       
    	        }
    	            
 	          })
 	          .catch(err => {
 	            // An error occurred
 	          });
    	        this.AddRadicalMensaje=  ' _ '+ this.formNewnRadical.Name_Radical +" add successful";
    	        
    	     
       },
       showmodal(index){
    	this.formodifi.ID_Radical=index.ID_Radical;
  	    this.formodifi.Name_Radical=index.Name_Radical;
 	    this.formodifi.Description=index.Description;
     	this.$refs['updateRadical'].show();
       },
       updateRadicallcule(){
    	   var key, count = 0;
      	   if(this.formodifi.Name_Radical===""  ) {
      		  	alert("Name  cannot be empty");
    	  	 	this.AddRadicalMensaje= (this.formodifi.Name_Radical)+"Error ";
    	  		return 0;
    	  	}
      	   

     	   for(key in this.items ) {
     		 if((this.items[key].Name_Radical.toUpperCase() ===this.formodifi.Name_Radical.toUpperCase()) && this.formodifi.ID_Radical != this.items[key].ID_Radical ){
     	  		alert("this Radical Exists");
     	  	 	this.AddRadicalMensaje= (this.formodifi.Name_Radical)+"Error ";
     	  		return 0;
     	  	 }
     	   }
           /* Initialize the form data */
           var formData = new FormData(); 
             
           /*  Add the form data we need to submit */
           if(this.formodifi.Image !="")
               formData.append('Image', this.formodifi.Image); 
           formData.append('Name_Radical', this.formodifi.Name_Radical);
           formData.append('Description', this.formodifi.Description);
           formData.append('RIS', this.formodifi.RIS);
           formData.append('_method','PUT');
            
           /* Make the request to the POST ../../RadicalTable URL */
           axios.post( '../../RadicalsTable/'+this.formodifi.ID_Radical,formData,{
           headers: { 'Content-Type': 'multipart/form-data'}}
           ).then(response =>{ 
        	   	console.log(response.data);	 
        	   	this.AddRadicalMensaje=  ' _ '+ this.formodifi.Name_Radical +" modify successful";
        	       axios.get('../../RadicalsTable').then(response =>{
        	           	this.items = response.data;
        	           	this.totalRows = this.items.length; 
        	           });
           }
           ).catch(function(){ this.AddRadicalMensaje= (this.formodifi.Name_Radical)+"Error ";}); 
           
           this.clearaddmol();
          
    
           this.$refs['updateRadical'].hide();
           axios.get('../../RadicalsTable').then(response =>{
              	this.items = response.data;
              	this.totalRows = this.items.length; 
              });
       },
    }
  }
</script>