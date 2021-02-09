<template>
  <b-container fluid class="bg-white p-2">
    <h1>Tables References</h1>
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
         <b-button v-b-modal.AddReference class="fa fa-save bg-success mx-4"> Add Reference</b-button>
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
      <template v-slot:cell(Coments)="row">
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
          <h1 class="fa fa-exclamation-circle text-success mt-auto p-2  mr-4 ">{{ AddReferenceMensaje}}</h1>
      </div>

    
    <b-modal ref="AddReference" id="AddReference" title="Add Reference"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <label  for="formNewReference.Coments" >Coments</label>
             <b-input
               id="formNewReference.Coments"
               v-model="formNewReference.Coments"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="Coments"
               name="Coments"
             ></b-input>
      
         
                 <b-col sm="2"class="mt-4">
               <label for="formNewReference.Reference">Reference</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formNewReference.Reference"
                 v-model="formNewReference.Reference"
                 size="sm"
                 placeholder="Reference"
             ></b-form-textarea>
             </b-col>
         
         </b-row>
       
       </form>
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa-save m-3  p-2 col-3 bg-success mx-4" @click = "AddReference()" >Add Reference</b-button>
        <b-button  block @click="$bvModal.hide('AddReference')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal>   
    <b-modal ref="updateReference" id="updateReference" title="Update Reference"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <div class="border border-info col-12 mt-4 p-4">id_reference: {{formodifi.id_reference}}</div> 
             <p><label  for="formNewReference.Coments" class="p-2">Coments</label></p>
             <b-input
               id="formodifi.Coments"
               v-model="formodifi.Coments"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="Coments"
               name="Coments"
             ></b-input>
                 <b-col sm="2"class="mt-4">
               <label for="formodifi.Reference">Reference</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formodifi.Reference"
                 v-model="formodifi.Reference"
                 size="sm"
                 placeholder="Reference"
             ></b-form-textarea>
             </b-col>
         </b-row>  
       </form> 
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa fa-refresh m-3  p-2 col-3 bg-success mx-4" @click = "updateReferencelcule()" >Edit Reference</b-button>
        <b-button  block @click="$bvModal.hide('updateReference')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal>
  </b-container>
</template>
<script>

  export default {
    data() {	
      return {
    	  isBusy:true,
    	formNewReference: {
    		id_reference:'',
    		Coments: '', 
    		Reference:'', 
    	},
    	formodifi: {
    		id_reference:'',
    		Coments: '', 
    		Reference:'', 
    	},
        items: [
          { Active: true, Reference: "...", Coments:  'Cargando espere porfavor'},
        ],
        AddReferenceMensaje:'',
        fields: [
          {key:'id_reference', label:'id', variant: 'success'},
          { key: 'Reference', label: 'Reference'  },
          { key: 'Coments', label: 'Coments', sortable: true },
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
 			Reference:'',
 			Coments: '',
		 
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
          });
      }
    },
    mounted() {
      // Set the initial number of items
      	this.totalRows = this.items.length
      	axios.get('../../ReferencesTable').then(response =>{
    	this.items = response.data;
    	this.totalRows = this.items.length;
        console.log(this.items);
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
    	this.formNewReference.Coments='';
     	this.formNewReference.Reference='';
      },
      
      AddReference(){
 	   var key, count = 0;
  		if(this.formNewReference.Reference ===""  ) {
  		  	alert("Reference  cannot be empty");
	  	 	this.AddReferenceMensaje= (this.formNewReference.Name_Solvent)+"Error ";
	  		return 0;
	  	}
       /* Initialize the form data */
       var formData = new FormData(); 
         
       /*  Add the form data we need to submit */
        formData.append('Coments', this.formNewReference.Coments);
        formData.append('Reference', this.formNewReference.Reference);
        
       /* Make the request to the POST ../../ReferenceTable URL */
       axios.post( '../../ReferencesTable',formData,{
       headers: { 'Content-Type': 'multipart/form-data'}}
       ).then(response =>{ 
    	   	console.log(response.data);	 
    	   	this.AddReferenceMensaje=  ' _ '+ this.formNewReference.Coments +" add successful";
    	    axios.get('../../ReferencesTable').then(response =>{
    	    	this.items = response.data;
    	    	this.totalRows = this.items.length;
    	       });
       }
       ).catch(function(){ this.AddReferenceMensaje= (this.formNewReference.Coments)+"Error ";}); 
       	
   
       
       this.clearaddmol();
      
       axios.get('../../ReferencesTable').then(response =>{
       	this.items = response.data;
       	this.totalRows = this.items.length;
	   });
       this.$refs['AddReference'].hide();
      }, 
      loadTextFromFile(ev) {
          const file = ev.target.files[0];
          const reader = new FileReader();
          reader.onload = e => {
        	  this.formodifi.RIS=e.target.result
        	  this.formNewReference.RIS =e.target.result};
          reader.readAsText(file);
       },
       Delete_id(index){
    	   
    	        this.$bvModal.msgBoxConfirm('Please confirm that you want to delete "'+index.Coments +'".', {
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
    	           	axios.delete( '../../ReferencesTable/'+index.id_reference).then(
    	            response =>{ 
    	               axios.get('../../ReferencesTable').then(response =>{
    	           	      	this.items = response.data;
    	           	       	this.totalRows = this.items.length;
    	           	       	
    	           	   });
 
    	            }).catch(function(){ this.AddReferenceMensaje= (this.formNewReference.Coments)+"Error ";}); 
    	         }
    	            
 	          })
 	          .catch(err => {
 	            // An error occurred
 	          });
    	        this.AddReferenceMensaje=  ' _ '+ this.formNewReference.Coments +" add successful";
    	        
    	     
       },
       showmodal(index){
    	this.formodifi.id_reference=index.id_reference;
  	    this.formodifi.Coments=index.Coments;
 	    this.formodifi.Reference=index.Reference;
     	this.$refs['updateReference'].show();
       },
       updateReferencelcule(){
    	   var key, count = 0;
           /* Initialize the form data */
           var formData = new FormData(); 
             
           /*  Add the form data we need to submit */
           formData.append('Coments', this.formodifi.Coments);
           formData.append('Reference', this.formodifi.Reference);
           formData.append('RIS', this.formodifi.RIS);
           formData.append('_method','PUT');
           /* Make the request to the POST ../../ReferenceTable URL */
           axios.post( '../../ReferencesTable/'+this.formodifi.id_reference,formData,{
           headers: { 'Content-Type': 'multipart/form-data'}}
           ).then(response =>{ 
        	   	console.log(response.data);	 
        	   	this.AddReferenceMensaje=  ' _ '+ this.formodifi.Coments +" modify successful";
                
                axios.get('../../ReferencesTable').then(response =>{
                	this.items = response.data;
                	this.totalRows = this.items.length; 
                });
           }
           ).catch(function(){ this.AddReferenceMensaje= (this.formodifi.Coments)+"Error ";}); 
           
           this.clearaddmol();
  
           this.$refs['updateReference'].hide();
           axios.get('../../ReferencesTable').then(response =>{
              	this.items = response.data;
              	this.totalRows = this.items.length; 
              });
       },
    }
  }
</script>