<template>
  <b-container fluid class="bg-white p-2">
    <h1>pKa  table</h1>
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
         <b-button  @click="modaladdKoverall" class="fa fa-save bg-success mx-4"> Add pKa </b-button>
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
        <template v-slot:cell(Tipo_Exp_teo)="row">
        <div v-if="row.value == 'T' ">
            Theoretical
         </div>
         <div v-else-if="row.value == 'E' ">
              Experimental
         </div>
        </template>

      <template v-slot:cell(Name)="row">
        {{ row.value }}
      </template>

      <template v-slot:cell(actions)="row">
        <b-button size="sm"  class="fa fa-trash   bg-danger  mr-1"  @click="Delete_id(row.item)"> <span class="text-info"> Delete </span></b-button>
        <b-button size="sm"  class="fa fa-refresh bg-warning mr-1" @click="showmodal(row.item)"> <span class="text-info"> Edit </span> </b-button>

      </template>
      <template v-slot:cell(Value)="row">
         <div v-if="row.item.Tipo_Exp_teo == 'T' ">
            {{row.value.toFixed(2)}}
         </div>
         <div v-else-if="row.item.Tipo_Exp_teo == 'E' ">
              {{row.value}}
         </div>
      </template>

      <template v-slot:cell(ris_image)="row">
         <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="fa fa-image mr-1 " >
          image
        </b-button>
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
     <b-img class="p-4" fluid-grow :src='data_mole.Image'/>
    </b-modal>

    <b-modal ref="addKoverall" id="addKoverall" title="Add pKa" size="xl"    hide-footer>
        <div><label>Molecule:</label> <b-form-select v-model="DataPKaNew.Molecule" :options="Molecules" ></b-form-select></div>
              {{DataPKaNew.Molecule}}
         <div v-if="DataPKaNew.Molecule != null && DataPKaNew.Molecule != 'null' && DataPKaNew.Molecule != -1">
            <b-img class="p-4" fluid-grow :src="imgs[DataPKaNew.Molecule]"/>
         </div>
         <div v-else-if="DataPKaNew.Molecule == null || DataPKaNew.Molecule ==-1">
         </div>
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


      <template v-slot:cell(Site)="row">
            <input type="text" size="5"  @input="ingresa(row)" v-model="row.value" />
      </template>
      <template v-slot:cell(Tipo_Exp_teo)="row">
         <b-form-select v-model="row.value"
                        size="10"
                        @input="ingresa(row)"
                        :options="typeoption ">
                        </b-form-select>
      </template>
      <template v-slot:cell(Value)="row" >
         <input type="text"  v-model="row.value"   size="7" @input="ingresa(row)"/>
      </template>
      <template v-slot:cell(Description)="row">
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
            <div class="border border-info col-12 mt-4 p-4">id_pks: {{formodifi.id_pks}}</div>


             <p><label  for="formodifi.Molecule" class="p-2">Molecule Name</label></p>




             <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Molecule"
              v-model="formodifi.Molecule"
              :options="Molecules"
              name="Molecule"
              >  </b-form-select>
             <div class="row p-4">
             <p><label  for="formodifi.Site" >Site</label></p>

             <input type="text" id="formodifi.Site"
              v-model="formodifi.Site"
               size="10" />

             <p><label  for="formodifi.Value" >Value</label></p>

             <input type="text" ref="ValueModifi"
              v-model="formodifi.Value "
               size="10" />
              </div>


            <b-row>
            <label for="formodifi.Tipo_Exp_teo">Type</label>
              <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Tipo_Exp_teo"
              v-model="formodifi.Tipo_Exp_teo"
              :options="typeoption"
              name="formodifi.Tipo_Exp_teo"
              >  </b-form-select>


             <p><label  for="formodifi.Mol_name" class="p-2">Reference</label></p>


             <b-form-select
              class="mb-2 mr-sm-2 mb-sm-0"
              id="formodifi.Reference"
              v-model="formodifi.Reference"
              :options="References"
              name="Reference"
              >  </b-form-select>
            <label for="formodifi.Description">Description</label>
             <b-form-textarea
                 id="formodifi.Description"
                 v-model="formodifi.Description"
                 size="sm"
                 placeholder="Small Description"
             ></b-form-textarea>
         </b-row>
         </b-row>
       </form>

      </b-container>
     <div class="row">
        <b-button  block  class="fa fa fa-refresh m-3  p-2 col-3 bg-success mx-4" @click = "updateK_Overalllcule()" >Edit molecule</b-button>
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
         id_pks:'',
         Name: '',
         SMILE: '',
         Description:'',
         RIS:'',
         Image: '',
         Tipo_Exp_teo :null,
      },
      formodifi: {
        Molecule: 1,
        Radical: -1,
        Solvent: -1,
        Site:null,
         Value:null,
        Description:null,
        Reference:-1,
        Tipo_Exp_teo:null,
      },
        items: [
          { Active: true, SMILE: "...", Name:  'Cargando espere porfavor'},
        ],
        typeoption:[
        	{value: 'T', text: 'Theoretical'},
        	{value: 'E', text: 'Experimental'},
        ],
        addMoleMensaje:'',
        fields: [
          { key:'id_pks',label:'id', variant: 'success', dblclick:"unmsj(row,$event)"},
          { key:'Name', label: 'Molecule name', sortable: true },
          { key:'Site', label: 'Site', variant: 'danger'},
          { key:'Value', label: 'Value', sortable: true , variant: 'info'},
          { key:'Tipo_Exp_teo', label:'Type', sortable: true },

          { key:'Description', label: 'Description'  },
          { key:'ris_image', label: 'Reference'},
          { key:'actions', label: 'Actions' },

        ],
        itemsAdd: [
         {Radical: -1,Solvent: -1,Tipo_Exp_teo:null, Site:null,Value:null, Description:null,Reference:-1 },
        ],

        fieldsAdd: [
            { key:'Site', label: 'Site' , variant: 'danger'},
            { key:'Value', label: 'Value', variant: 'info'},
            { key:'Tipo_Exp_teo',label:'Type', sortable: true },
            { key:'Description', label: 'Description'  },
            { key:'Reference', label: 'Alternative reference'  },
        ],

        DataPKaNew:{
         Molecule:-1,
         Radical: -1,
         Solvent:-1,
         Site:null,
         Value:null,
         Description:null,
         Tipo_Exp_teo:-1,
         Reference:-1,
        },
        Molecules:   [{value: -1, text: 'Please select an option'},],
        Radicals: [{value: -1, text: 'Please select an option'},],
        Solvents: [{value: -1, text: 'Please select an option'},],
        References:  [{value: -1, text: 'Default for molecule'},],

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
      imgs:[],
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
       axios.get('../../PK_sTable').then(response =>{
           console.log(response.data );

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
                  axios.delete( '../../PK_sTable/'+index.id_pks).then(
                  response =>{
                     axios.get('../../PK_sTable').then(response =>{
                           this.items = response.data;
                           this.totalRows = this.items.length;

                     });

                  }).catch(function(){ this.addMoleMensaje= "Error ";});
              }

             })
             .catch(err => {
               // An error occurred
             });
             this.addMoleMensaje=  " add successful";

       },
       showmodal(index){

          this.formodifi.id_pks=index.id_pks;
          this.formodifi.Radical=index.ID_Radical;
          this.formodifi.Solvent=index.Solvent;
          this.formodifi.Site=index.Site;
          this.formodifi.Value=index.Value;
          this.formodifi.Description=index.Description;
          this.formodifi.Reference=index.id_reference;
          this.formodifi.Molecule=index.ID;
          this.formodifi.Tipo_Exp_teo=index.Tipo_Exp_teo;

          this.$refs['updateK_Overall'].show();
       },
       updateK_Overalllcule(){

         if(this.formodifi.Value==="" ||  this.formodifi.Value ===null
               ||this.formodifi.Molecule==="" ||  this.formodifi.Molecule ===null ||  this.formodifi.Molecule ===-1  ) {
            alert("Value and Molecule  cannot be empty");
            this.AddRadicalMensaje= "Error ";
            return 0;
         }

         var formData = new FormData();


          formData.append('Id_Molecule', this.formodifi.Molecule);
            formData.append('Site',this.formodifi.Site);
            formData.append('Description', this.formodifi.Description);
            formData.append('Reference', this.formodifi.Reference);
            formData.append('Value', this.formodifi.Value);
            formData.append('Type', this.formodifi.Tipo_Exp_teo);


            formData.append('_method','PUT');
         axios.post( '../../PK_sTable/'+this.formodifi.id_pks,formData,{
           headers: { 'Content-Type': 'multipart/form-data'}}
           ).then(response =>{
                this.addMoleMensaje=  " _ modify successful";
                axios.get('../../PK_sTable').then(response =>{
                    this.items = response.data;
                    this.totalRows = this.items.length;
                   });
           }
           ).catch(function(){
               });


           this.$refs['updateK_Overall'].hide();





           axios.get('../../PK_sTable').then(response =>{
               this.items = response.data;
               this.totalRows = this.items.length;
                this.isBusy= false;
             });
             this.$refs['addKoverall'].hide();
             this.totalRows = this.items.length
             axios.get('../../PK_sTable').then(response =>{
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
			this.imgs[value]="../../files/data-base-img/"+this.itemsMolecules[key].ID+ "/"+this.itemsMolecules[key].Imagen;
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
         this.itemsAdd.push({Radical: -1,Solvent: -1, Site:null,Value:null, Description:null,Reference:-1 },);
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
          if(this.DataPKaNew.Molecule===null || this.DataPKaNew.Molecule=== -1 ) {
             alert("Select a molecule");
             this.addMoleMensaje = "Error ";
             return 0;
          }

        var idmolecule=this.DataPKaNew.Molecule;
        this.DataPKaNew.Molecule=-1;
         var formData = new FormData();

          var item =null
        while(this.itemsAdd.length>0){
          item = this.itemsAdd.pop();
          if(item.Value===null ) continue;
           formData = new FormData();
           	 formData.append('Id_Molecule', idmolecule);
             formData.append('Site',item.Site);
             formData.append('Description', item.Description);
             formData.append('Reference', item.Reference);
             formData.append('Value', item.Value);
             formData.append('Type', item.Tipo_Exp_teo);

             axios.post( '../../PK_sTable',formData,{

               headers: { 'Content-Type': 'multipart/form-data'}}
             ).then(response =>{
                   this.addMoleMensaje= " add successful";
              	console.log(response.data);
                axios.get('../../PK_sTable').then(response =>{
                    this.items = response.data;
                    this.totalRows = this.items.length;
                     this.isBusy= false;
                  });
             }
             ).catch(function(){});
        }
           this.$refs['addKoverall'].hide();
           this.totalRows = this.items.length
           axios.get('../../PK_sTable').then(response =>{
             this.items = response.data;
             this.totalRows = this.items.length;
              this.isBusy= false;
           });
       },
    }
  }
</script>
