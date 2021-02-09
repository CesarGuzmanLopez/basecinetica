
<template>
  <b-container fluid class="bg-white p-2">
    <h1>K<sub>overall</sub> table</h1>
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
         <b-button  @click="modaladdKoverall" class="fa fa-save bg-success mx-4"> Add K<sub>overall</sub></b-button>
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
       hover
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
        <div class="text-center text-dark my-2">
          <b-spinner small label="align-middle" variant="dark"></b-spinner>
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
      <template v-slot:cell(Valor)="row">
         {{row.item.Valor.toPrecision(3)}}
      </template>


      <template v-slot:cell(ris_image)="row">
        <b-button size="sm" @click="row.toggleDetails" class="fa fa-file-text ">
          {{ row.detailsShowing ? 'Hide' : 'Show' }} Reference
        </b-button>
      </template>

      <template v-slot:row-details="row">
        <b-card >
         <div v-if="row.item.Reference != null && row.item.Reference != 'null'">
             <b-form-textarea
               rows="6"
               max-rows="10"
               :value='row.item.Reference'
             ></b-form-textarea>
         </div>
         <div v-else-if="row.item.RIS != null">
             <b-form-textarea
               rows="6"
               max-rows="10"
               :value='row.item.RIS'
             ></b-form-textarea>
         </div>
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
     <b-img :src='data_mole.Image'/>
    </b-modal>

    <b-modal ref="addKoverall" id="addKoverall" title="addKoverall" size="xl"    hide-footer>
        <div><label>Molecule:</label> <b-form-select v-model="Data_pKaN.Molecule" :options="Molecules"></b-form-select></div>

      <b-table
      show-empty
      responsive="sm"
      striped
      small
      :items="itemsAdd"
      :fields="fieldsAdd"

      >

      <template v-slot:cell(Radical)="row">
         <b-form-select v-model="row.value" @input="ingresa(row)" :options="Radicals" ></b-form-select>


      </template>
      <template v-slot:cell(Solvent)="row">
         <b-form-select v-model="row.value" @input="ingresa(row)" :options="Solvents"></b-form-select>
       </template>

      <template v-slot:cell(pH)="row">
            <input type="text" size="3"  @input="ingresa(row)" v-model="row.value" />
       </template>
      <template v-slot:cell(Tipo)="row">
                <b-form-select v-model="row.value" size="10" @input="ingresa(row)"  :options="typeoption "></b-form-select>
       </template>
      <template v-slot:cell(Valor)="row" >
         <input type="text"  v-model="row.value"   size="7" @input="ingresa(row)"/>
      </template>
      <template v-slot:cell(Descripcion)="row">

                  <input type="text"  v-model="row.value"  @input="ingresa(row)"/>
      </template>
       <template v-slot:cell(Reference)="row">
              <b-form-select v-model="row.value" @input="ingresa(row)"  :options="References"></b-form-select>
       </template>
    </b-table>
    <b-button  @click="additem" class="fa fa-plus-circle bg-success mx-4"></b-button>
    <b-button  @click="popitem" class="fa fa-minus bg-danger mx-4"></b-button>

    <b-button  @click="cloneitem" class="fa fa-clone bg-success mx-4"></b-button>
   <div> <b-button  @click="addSaveitem" class="fa fa-save bg-info mx-4 float-right"> Save</b-button></div>
   </b-modal>



    <b-modal ref="updateK_Overall" id="updateK_Overall" title="Update Koverall"   hide-footer>
      <b-container fluid>
       <form enctype="multipart/form-data">

         <b-row>
            <div class="border border-info col-12 mt-4 p-4">ID_K_OVERALL: {{formodifi.ID_K_OVERALL}}</div>


             <p><label  for="formodifi.Molecule" class="p-2">Molecule Name</label></p>



             <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Molecule"
              v-model="formodifi.Molecule"
              :options="Molecules"
              name="Molecule"
              >  </b-form-select>
             <div class="row p-4">
             <p><label  for="formodifi.pH" >pH</label></p>

             <input type="text" id="formodifi.pH"
              v-model="formodifi.pH"
               size="10" />

             <p><label  for="formodifi.Valor" >Valor</label></p>

             <input type="text" ref="ValorModifi"
              v-model="formodifi.Valor "
               size="10" />
              </div>

             <div class="mb-2 row       ">

            <label  for="formodifi.Radical" class="p-2">Radical</label>


             <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Radical"
              v-model="formodifi.Radical"
              :options="Radicals"
              name="Radical"
              >  </b-form-select>



             <label  for="formodifi.Solvent" class="p-2">Solvent</label>


             <b-form-select
              mr-sm-2 mb-sm-0
              id="formodifi.Solvent"
              v-model="formodifi.Solvent"
              :options="Solvents"
              name="Solvent"

              >  </b-form-select>
            </div>
             <p><label  for="formodifi.Mol_name" class="p-2">Reference</label></p>


             <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Reference"
              v-model="formodifi.Reference"
              :options="References"
              name="Reference"
              >  </b-form-select>



            <label for="formodifi.Descripcion">Description</label>


             <b-form-textarea
                 id="formodifi.Descripcion"
                 v-model="formodifi.Descripcion"
                 size="sm"
                 placeholder="Small Description"
             ></b-form-textarea>

             <label for="formodifi.Tipo">Type</label>
              <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Tipo"
              v-model="formodifi.Tipo"
              :options="typeoption"
              name="formodifi.Tipo"
              >  </b-form-select>




         </b-row>
       </form>

      </b-container>
     <div class="row">
        <b-button  block  class="fa fa fa-refresh m-3  p-2 col-3 bg-success mx-4" @click = "updateK_Overalllcule()" ><sub>edit</sub></b-button>
        <b-button  block @click="$bvModal.hide('updateK_Overall')" class=" m-3  p-2 col-3 bg-danger mx-4">Cerrar</b-button>
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
         ID_K_OVERALL:'',
         Name: '',
         SMILE: '',
         Description:'',
         RIS:'',
         Image: '',
      },
      formodifi: {
    	  Molecule: 1,
    	  Radical: -1,
    	  Solvent: -1,
    	  pH:null,
    	  Tipo:'Theo. with f_M',
    	  Valor:null,
    	  Descripcion:null,
    	  Reference:-1,
      },
        items: [
          { Active: true, SMILE: "...", Name:  'Cargando espere porfavor'},
        ],

        addMoleMensaje:'',
        fields: [
          { key:'ID_K_OVERALL',label:'id', variant: 'success', dblclick:"unmsj(row,$event)"},
          { key:'Name', label: 'Molecule name', sortable: true },
          { key:'Name_Radical', label: 'Radical', sortable: true },
          { key:'Name_Solvent', label: 'Solvent', sortable: true },
          { key:'Valor', label: 'Value', sortable: true , variant: 'info'},
          { key:'pH', label:'pH', sortable: true },
          { key:'Tipo', label:'Type', sortable: true },
          { key:'Descripcion', label: 'Description'  },
          { key:'ris_image', label: 'Reference'},
          { key:'actions', label: 'Actions' },
        ],
        itemsAdd: [
        	{Radical: -1,Solvent: -1, pH:null,Tipo:'Theo. with f_M',Valor:null, Descripcion:null,Reference:-1 },
        ],
        typeoption:[
        	{value: 'Theo. with f_M', text: 'Theo. with f_M'},
        	{value: 'Experimental', text: 'Experimental'},
        	{value: 'Theo. without f_M', text: 'Theo. without f_M'},
       ],
        fieldsAdd: [
            { key:'Radical', label: 'Radical'  },
            { key:'Solvent', label: 'Solvent'},
            { key:'pH', label:'pH'  },
            { key:'Tipo', label:'Type'},
            { key:'Valor', label: 'Value', variant: 'info'},
            { key:'Descripcion', label: 'Description'  },
            { key:'Reference', label: 'Alternative reference'  },
           ]
        ,

        Data_pKaN:{
        	Molecule:-1,
        	Radical: -1,
        	Solvent:-1,
        	pH:null,
        	Value:null,
        	Description:null,
        	Type:-1,
        	Reference:-1,
        },
        Molecules:	[{value: -1, text: 'Please select an option'},],
        Radicals:	[{value: -1, text: 'Please select an option'},],
        Solvents:	[{value: -1, text: 'Please select an option'},],
        References:	[{value: -1, text: 'Default for molecule'},],

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
         Description:'',
         SMILE: '',
         Name: '',
         RIS:'',
      },
      itemsMolecules:{},
      itemsferences:{},
      itemsSolvents:{},
      itemsRadicals:{},

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
 	   this.getReferences();
	   this.getMolecules();
	   this.getSolvents();
	   this.getRadicals();

       // Set the initial number of items
       this.totalRows = this.items.length
       axios.get('../../K_overalsTable').then(response =>{
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
      this.data_mole.Image=  "../../files/data-base-img/"+item.ID_K_OVERALL+ "/"+item.Imagen;
      this.data_mole.Name=item.Name;

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
                  axios.delete( '../../K_overalsTable/'+index.ID_K_OVERALL).then(
                  response =>{
                     axios.get('../../K_overalsTable').then(response =>{
                           this.items = response.data;
                           this.totalRows = this.items.length;

                     });

                  }).catch(function(){ this.addMoleMensaje= ("Error ");});
              }

             })
             .catch(err => {
               // An error occurrfed
             });
             this.addMoleMensaje=  " _  add successful";

       },
       showmodal(index){

     	  this.formodifi.ID_K_OVERALL=index.ID_K_OVERALL;
          this.formodifi.Radical=index.ID_Radical;
          this.formodifi.Solvent=index.Solvent;
          this.formodifi.pH=index.pH;
          this.formodifi.Valor=index.Valor;
          this.formodifi.Descripcion=index.Descripcion;
          this.formodifi.Reference=index.id_reference;
          this.formodifi.Tipo=index.Tipo;
          this.formodifi.Molecule=index.ID_Molecule;

          this.$refs['updateK_Overall'].show();
       },
       updateK_Overalllcule(){

    	   if(this.formodifi.Valor==="" ||  this.formodifi.Valor ===null
    			   ||this.formodifi.Molecule==="" ||  this.formodifi.Molecule ===null ||  this.formodifi.Molecule ===-1  ) {
     		  	alert("Value and Molecule  cannot be empty");
   	  	 	this.AddRadicalMensaje= "Error ";
   	  		return 0;
   	  	}

    	   var formData = new FormData();


    	    formData.append('Id_Molecule', this.formodifi.Molecule);
            formData.append('Radical',this.formodifi.Radical);
            formData.append('Solvent', this.formodifi.Solvent);
            formData.append('pH',this.formodifi.pH);
            formData.append('Tipo', this.formodifi.Tipo);
            formData.append('Descripcion', this.formodifi.Descripcion);
            formData.append('Reference', this.formodifi.Reference);
            formData.append('Valor', this.formodifi.Valor);
            formData.append('_method','PUT');
    	   axios.post( '../../K_overalsTable/'+this.formodifi.ID_K_OVERALL,formData,{
           headers: { 'Content-Type': 'multipart/form-data'}}
           ).then(response =>{
                this.addMoleMensaje=  " _ modify successful";

                axios.get('../../K_overalsTable').then(response =>{
                    this.items = response.data;
                    this.totalRows = this.items.length;
                     this.isBusy= false;
                  });
           }
           ).catch(function(){
         	   });

           this.$refs['updateK_Overall'].hide();





             this.$refs['addKoverall'].hide();
             this.totalRows = this.items.length
             axios.get('../../K_overalsTable').then(response =>{
               this.items = response.data;
               this.totalRows = this.items.length;
                this.isBusy= false;
             });




       },
       getMolecules(){
		axios.get('../../MoleculeTable').then(response =>{
 		   this.itemsMolecules=response.data;
  	       var key,value,text;
  		   for(key in this.itemsMolecules){
  	    		value=this.itemsMolecules[key].ID;
  	    		text="<h1>"+this.itemsMolecules[key].ID+"</h1> "+this.itemsMolecules[key].Name;
  	    		this.Molecules.push({value,text});
  	       }
		});
       },
       getReferences(){
    		axios.get('../../ReferencesTable').then(response =>{
    			this.itemsferences=response.data;
    	  	       var key,value,text;
    	  		   for(key in this.itemsferences){
    	  	    		value= this.itemsferences[key].id_reference;
    	  	    		text=this.itemsferences[key].id_reference+" "+this.itemsferences[key].Reference.substr(0,20);
    	  	    		this.References.push({value,text});
    	  	       }
 		   });
       },
       getSolvents(){
     		axios.get('../../SolventsTable').then(response =>{
     		   this.itemsSolvents= response.data;
 	  	       var key,value,text;
	  		   for(key in this.itemsSolvents){
	  	    		value =this.itemsSolvents[key].ID_Solvent;
	  	    		text  =this.itemsSolvents[key].Name_Solvent;
	  	    		this.Solvents.push({value,text});
	  	       }
 		   });
       },
       getRadicals(){
  		axios.get('../../RadicalsTable').then(response =>{
 		this.itemsRadicals = response.data;
	       var key,value,text;
  		   for(key in this.itemsRadicals){
  	    		value=this.itemsRadicals[key].ID_Radical;
  	    		text=this.itemsRadicals[key].Name_Radical;
  	    		this.Radicals.push({value,text});
  	       }
  		});
       },
       modaladdKoverall(){
          	this.$refs['addKoverall'].show();
       },
       additem(){
    	   this.itemsAdd.push({Radical: -1,Solvent: -1, pH:null,Tipo:'Theo. with f_M',Valor:null, Descripcion:null,Reference:-1 },);
       },
       cloneitem(){
	   	var tem =this.itemsAdd[this.itemsAdd.length-1];
  	   	this.itemsAdd.push(JSON.parse(JSON.stringify(tem)));
        },
       ingresa(row){
    	   var g;
    	   g=row.value;
     	   this.itemsAdd[row.index][row.field.key]=g;

       },
       popitem(){
    	   this.itemsAdd.pop();
       },
       addSaveitem(){
 	       var key, count = 0;
  	       if(this.Data_pKaN.Molecule===null || this.Data_pKaN.Molecule=== -1 ) {
 	          alert("Select a molecule");
 	          this.addMoleMensaje = "Error ";
 	          return 0;
 	       }
    	  var idmolecule=this.Data_pKaN.Molecule;
    	  this.Data_pKaN.Molecule=-1;
 	      var formData = new FormData();

          var item =null
 		  while(this.itemsAdd.length>0){
			 item = this.itemsAdd.pop();
			 if(item.Valor===null ) continue;
	 	     formData = new FormData();

    	     formData.append('Id_Molecule', idmolecule);
             formData.append('Radical', item.Radical);
             formData.append('Solvent', item.Solvent);
             formData.append('pH',item.pH);
             formData.append('Tipo', item.Tipo);
             formData.append('Descripcion', item.Descripcion);
             formData.append('Reference', item.Reference);
             formData.append('Valor', item.Valor);

             axios.post( '../../K_overalsTable',formData,{

            	headers: { 'Content-Type': 'multipart/form-data'}}
             ).then(response =>{
                   this.addMoleMensaje= " add successful";
                   axios.get('../../K_overalsTable').then(response =>{
                       this.items = response.data;
                       this.totalRows = this.items.length;
                        this.isBusy= false;
                     });
             }
             ).catch(function(){ this.addMoleMensaje= "Error ";});

		  }

           this.$refs['addKoverall'].hide();
           this.totalRows = this.items.length
           axios.get('../../K_overalsTable').then(response =>{
             this.items = response.data;
             this.totalRows = this.items.length;
              this.isBusy= false;
           });
       },
    }
  }

</script>
