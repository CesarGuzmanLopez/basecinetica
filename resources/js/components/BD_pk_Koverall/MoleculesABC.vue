<template>
  <b-container fluid class="bg-white p-2">
    <h1>Tables Molecules.</h1>

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
            <b-form-checkbox value="Name">Molecule</b-form-checkbox>
            <b-form-checkbox value="SMILE">Smile</b-form-checkbox>
            <b-form-checkbox value="RIS">RIS</b-form-checkbox>
            <b-button v-b-modal.addmole class="fa fa-save bg-success mx-4"> Add molecule</b-button>
          </b-form-checkbox-group>
        </b-form-group>
      </b-col> 
    
    </div>

    <!-- Main table element -->
    <b-table
      show-empty
      small
      stacked="md"
      responsive="sm"
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
      <template v-slot:cell(Name)="row">
        {{ row.value }} 
      </template>

      <template v-slot:cell(actions)="row">
        <b-button size="sm"  class="fa fa-trash   bg-danger  mr-1"  @click="Delete_id(row.item)"> <span class="text-info"> Delete </span></b-button>
        <b-button size="sm"  class="fa fa-refresh bg-warning mr-1" @click="showmodal(row.item)"> <span class="text-info"> Edit </span> </b-button>
    
      </template>
      <template v-slot:cell(ris_image)="row">
          <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="fa fa-image mr-1 " >
          image
        </b-button>
        <b-button size="sm" @click="row.toggleDetails" class="fa fa-file-text ">
          {{ row.detailsShowing ? 'Hide' : 'Show' }} RIS
        </b-button>
      
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
          <h1 class="fa fa-exclamation-circle text-success mt-auto p-2  mr-4 ">{{ addMoleMensaje}}</h1>
      </div>
    <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
     <b-img class="p-4" fluid-grow :src='data_mole.Image'/>
    </b-modal> 
    
    <b-modal ref="addmole" id="addmole" title="Add molecule"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <label  for="formNewnMole.Mol_name" >Molecule Name</label>
             <b-input
               id="formNewnMole.Name"
               v-model="formNewnMole.Name"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="Molecule Name"
               name="Mol_name"
             ></b-input>
             <label  for="formNewnMole.SMILE">Smile</label>
             <b-input-group class="mb-2 mr-sm-2 mb-sm-0">
               <b-input id="formNewnMole.SMILE" v-model="formNewnMole.SMILE" placeholder="Smile"></b-input>
             </b-input-group>
         
                 <b-col sm="2"class="mt-4">
               <label for="formNewnMole.Description">Description</label>
             </b-col>
             <b-col sm="10"  class="mt-4">
             <b-form-textarea
                 id="formNewnMole.Description"
                 v-model="formNewnMole.Description"
                 size="sm"
                 placeholder="Small Description"
             ></b-form-textarea>
             </b-col>
               <div class="border border-info col-12 mt-4">
               <b-col sm="2"class="mt-4">
                  <h4><label for="formNewnMole.RIS" >RIS:</label></h4>
             </b-col>
              <b-col sm="12" class="my-4" >
              <b-form-file class="m-3" @change="loadTextFromFile" id="formNewnMole.RISFile" plain></b-form-file>
                <b-form-textarea
                v-model="formNewnMole.RIS"
                 id="formNewnMole.RIS"
                 name="RIS"
                 placeholder="RIS"
               ></b-form-textarea>
             </b-col>
             </div>
         </b-row>
         <b-row>
             <div class="border border-info col-12 mt-4">
                 <label for="formNewnMole.imagemol" class="p-1"
                 >Molecule image</label>
                 <input class="p-3" type="file" ref="formNewnMole_imagemol" v-on:change="handleFileUpload()" id="formNewnMole_imagemol" name="imagemol"  accept="image/*">
             </div>
         </b-row>  
       </form>
       
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa-save m-3  p-2 col-3 bg-success mx-4" @click = "addMolelcule()" >Add molecule</b-button>
        <b-button  block @click="$bvModal.hide('addmole')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal>
   
   
   
    <b-modal ref="updatemole" id="updatemole" title="Update molecule"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">
         <b-row>
            <div class="border border-info col-12 mt-4 p-4">ID: {{formodifi.ID}}</div> 
             <p><label  for="formodifi.Mol_name" class="p-2">Molecule Name</label></p>
             <b-input
               id="formodifi.Name"
               v-model="formodifi.Name"
               class="mb-2 mr-sm-2 mb-sm-0"
               placeholder="Molecule Name"
               name="Mol_name"
             ></b-input>
             <label  for="formodifi.SMILE">Smile</label>
             <b-input-group class="mb-2 mr-sm-2 mb-sm-0">
               <b-input id="formodifi.SMILE" v-model="formodifi.SMILE" placeholder="Smile"></b-input>
             </b-input-group>
         
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
               <div class="border border-info col-12 mt-4">
               <b-col sm="2"class="mt-4">
                  <h4><label for="formodifi.RIS" >RIS:</label></h4>
             </b-col>
              <b-col sm="12" class="my-4" >
              <b-form-file class="m-3" @change="loadTextFromFile" id="formodifi.RISFile" plain></b-form-file>
                <b-form-textarea
                v-model="formodifi.RIS"
                 id="formodifi.RIS"
                 name="RIS"
                 placeholder="RIS"
               ></b-form-textarea>
             </b-col>
             </div>
         </b-row>
         <b-row>
             <div class="border border-info col-12 mt-4">
                 <label for="formodifi.imagemol" class="p-1"
                 >Molecule image</label>
                 : {{formodifi.Image}}
                 <input class="p-3" type="file" ref="formodifi_imagemol" v-on:change="handleFileUploadup()" id="formodifi_imagemol" name="imagemol"  accept="image/*">
             </div>
         </b-row>  
       </form>
       
      </b-container>
     <div class="row">
        <b-button  block  class="fa fa fa-refresh m-3  p-2 col-3 bg-success mx-4" @click = "updateMolelcule()" >Edit molecule</b-button>
        <b-button  block @click="$bvModal.hide('updatemole')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>    
     </div>
   </b-modal>
   
   
  </b-container>

</template>

<script>

  export default {
    data() {	
      return {
    	isBusy:true,
    	formNewnMole: {
    		ID:'',
    		Name: '',
    		SMILE: '',
    		Description:'',
    		RIS:'',
    		Image: '',
    	},
    	formodifi: {
    		ID:'',
    		Name: '',
    		SMILE: '',
    		Description:'',
    		RIS:'',
    		Image: '',
    	},
        items: [
          { Active: true, SMILE: "...", Name:  'Cargando espere porfavor'},
        ],
        addMoleMensaje:'',
        fields: [
          {key:'ID',label:'id', variant: 'success'},
          { key: 'Name', label: 'Molecule name', sortable: true },
          { key: 'SMILE', label: 'SMILE', sortable: false,click:'imgAndData',  class: 'text-center', lg:6 },
          { key: 'Description', label: 'Description'  },
          { key:'ris_image', label: 'Image Ris'},
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
			Image: '../../img/matrazRoto.png',
 			Description: '',
			Name: '',
			RIS:'',
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
      	axios.get('../../MoleculeTable').then(response =>{
    	this.items = response.data;
    	this.totalRows = this.items.length;
    	this.isBusy= false;
      });
      
    },
    methods: {
      info(item, index, button) {
    	this.imgAndData(item, index, event) 
        this.infoModal.title = item.Name;
        this.infoModal.content = JSON.stringify(item, null, 2)
        this.$root.$emit('bv::show::modal', this.infoModal.id, button)
      }, 
      resetInfoModal() {
        this.infoModal.title = ''
        this.infoModal.content = ''
      },
      onFiltered(filteredItems) {
        // Trigger pagination to update the number of buttons/pages due to filtering
        this.totalRows = filteredItems.length
        this.currentPage = 1
      },
      imgAndData(item, index, event){  
    	this.data_mole.Image=  "../../files/data-base-img/"+item.ID+ "/"+item.Imagen;
    	this.data_mole.Name=item.Name;
    	 
      },
      clearaddmol(){
    	this.formNewnMole.Name='';
    	this.formNewnMole.SMILE= '';
    	this.formNewnMole.Description='';
    	this.formNewnMole.RIS='';
    	this.formNewnMole.Image= '';
      },
      
      addMolelcule(){
 	   var key, count = 0;
  	   if(this.formNewnMole.Name==="" || this.formNewnMole.SMILE==="" ) {
  		  	alert("Name or Smile cannot be empty");
	  	 	this.addMoleMensaje= (this.formNewnMole.Name)+"Error ";
	  		return 0;
	  	}
  	   

 	   for(key in this.items ) {
 		 if(this.items[key].Name.toUpperCase() ===this.formNewnMole.Name.toUpperCase() || 
 	  	   this.items[key].SMILE.toUpperCase()=== this.formNewnMole.SMILE.toUpperCase() ){
 	  		alert("this Molecule or Smile Exists");
 	  	 	this.addMoleMensaje= (this.formNewnMole.Name)+"Error ";
 	  		return 0;
 	  	 }
 	   }
       /* Initialize the form data */
       var formData = new FormData(); 
         
       /*  Add the form data we need to submit */
       formData.append('Image', this.formNewnMole.Image);
       formData.append('Name', this.formNewnMole.Name);
       formData.append('SMILE', this.formNewnMole.SMILE);
       formData.append('Description', this.formNewnMole.Description);
       formData.append('RIS', this.formNewnMole.RIS);
       
       /* Make the request to the POST ../../MoleculeTable URL */
       axios.post( '../../MoleculeTable',formData,{
       headers: { 'Content-Type': 'multipart/form-data'}}
       ).then(response =>{ 
    	   	console.log(response.data);	 
    	   	this.addMoleMensaje=  ' _ '+ this.formNewnMole.Name +" add successful";
    	       axios.get('../../MoleculeTable').then(response =>{
    	       	this.items = response.data;
    	       	this.totalRows = this.items.length;
    	          });
       }
       ).catch(function(){ this.addMoleMensaje= (this.formNewnMole.Name)+"Error ";}); 
       	

       
       this.clearaddmol();
        axios.get('../../MoleculeTable').then(response =>{
       	this.items = response.data;
       	this.totalRows = this.items.length;
	   });
       this.$refs['addmole'].hide();
      },
      handleFileUpload(){
    	  this.formNewnMole.Image = this.$refs.formNewnMole_imagemol.files[0];

      },
      handleFileUploadup(){
    	  this.formodifi.Image = this.$refs.formodifi_imagemol.files[0];

      },
      loadTextFromFile(ev) {
          const file = ev.target.files[0];
          const reader = new FileReader();
          reader.onload = e => {
        	  this.formodifi.RIS=e.target.result
        	  this.formNewnMole.RIS =e.target.result};
          reader.readAsText(file);
       },
       Delete_id(index){
    	   
    	        this.$bvModal.msgBoxConfirm('Please confirm that you want to delete "'+index.Name +'".', {
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
    	           	axios.delete( '../../MoleculeTable/'+index.ID).then(
    	            response =>{ 
    	               axios.get('../../MoleculeTable').then(response =>{
    	           	      	this.items = response.data;
    	           	       	this.totalRows = this.items.length;
    	           	       	
    	           	   });
 
    	            }).catch(function(){ this.addMoleMensaje= (this.formNewnMole.Name)+"Error ";}); 
    	            	       
    	        }
    	            
 	          })
 	          .catch(err => {
 	            // An error occurred
 	          });
    	        this.addMoleMensaje=  ' _ '+ this.formNewnMole.Name +" add successful";
    	        
    	     
       },
       showmodal(index){
    	this.formodifi.ID=index.ID;
 	    this.formodifi.Image="";
 	    this.formodifi.Name=index.Name;
 	    this.formodifi.SMILE=index.SMILE;
 	    this.formodifi.Description=index.Description;
 	    this.formodifi.RIS=index.RIS;
    	this.$refs['updatemole'].show();
       },
       updateMolelcule(){
    	   var key, count = 0;
      	   if(this.formodifi.Name==="" || this.formodifi.SMILE==="" ) {
      		  	alert("Name or Smile cannot be empty");
    	  	 	this.addMoleMensaje= (this.formodifi.Name)+"Error ";
    	  		return 0;
    	  	}
      	   

     	   for(key in this.items ) {
     		 if((this.items[key].Name.toUpperCase() ===this.formodifi.Name.toUpperCase() || 
     	  	   this.items[key].SMILE.toUpperCase()=== this.formodifi.SMILE.toUpperCase()) && this.formodifi.ID != this.items[key].ID ){
     	  		alert("this Molecule or Smile Exists");
     	  	 	this.addMoleMensaje= (this.formodifi.Name)+"Error ";
     	  		return 0;
     	  	 }
     	   }
           /* Initialize the form data */
           var formData = new FormData(); 
             
           /*  Add the form data we need to submit */
           if(this.formodifi.Image !="")
               formData.append('Image', this.formodifi.Image); 
           formData.append('Name', this.formodifi.Name);
           formData.append('SMILE', this.formodifi.SMILE);
           formData.append('Description', this.formodifi.Description);
           formData.append('RIS', this.formodifi.RIS);
           formData.append('_method','PUT');
           console.log(this.formodifi.Name +" + "+this.formodifi.SMILE)
           
           /* Make the request to the POST ../../MoleculeTable URL */
           axios.post( '../../MoleculeTable/'+this.formodifi.ID,formData,{
           headers: { 'Content-Type': 'multipart/form-data'}}
           ).then(response =>{ 
        	   	console.log(response.data);	 
        	   	this.addMoleMensaje=  ' _ '+ this.formodifi.Name +" modify successful";
        	     axios.get('../../MoleculeTable').then(response =>{
        	           	this.items = response.data;
        	           	this.totalRows = this.items.length;
        	    
        	             });   
           }
           ).catch(function(){ this.addMoleMensaje= (this.formodifi.Name)+"Error ";}); 
           
           this.clearaddmol();
          
           axios.get('../../MoleculeTable').then(response =>{
           	this.items = response.data;
           	this.totalRows = this.items.length;
    
             });
           this.$refs['updatemole'].hide();
       },
    }
  }
</script>