if($("#up_app").length!=0)
var Compare_kO = new Vue({
    el: '#up_app',

    data() {
        return {
        isBusy:true,
        formNewnapp: {
        	 Name_app:"",
             Enable:"",
             app_EXE:"",
             Version:"",
             Description:"",

        },
        formodifi: {
       	 Name_app:"",
         Enable:"",
         app_EXE:"",
         Description:"",
         Version:"",
        },

          items: [

          ],

          addappMensaje:'',
          fields: [
            { key:'ID_app',label:'ID', variant: 'success', dblclick:"unmsj(row,$event)"},
            { key:'Name_app', label: 'App Name', sortable: true },
            { key:'Version', label: 'Version', variant: 'danger'},
            { key:'Location_name', label: 'Location', sortable: true , variant: 'info'},
            { key:'Enable', label:'Enable', sortable: true },
            { key:'Description', label: 'Description'},
            { key:'actions', label: 'Actions' },

          ],
          totalRows: 1,
          currentPage: 1,
          perPage: 15,
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
        data_app:{
        	  Name_app: '',
              Version: '',
              Description:'',
              app: '',
              Enable :true,
        },
        itemsapplication:{},
    	  Name_app: '',
          Version: '',
          Description:'',
          app: '',
          Enable :true,
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
         axios.get('upAppsDesktop').then(response =>{
             console.log(response.data );
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


         Delete_id(index){

                this.$bvModal.msgBoxConfirm('Please confirm that you want to delete "'+index.Name_app +'".', {
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
                    axios.delete( 'upAppsDesktop/'+index.ID_app).then(
                    response =>{
                       axios.get('upAppsDesktop').then(response =>{
                             this.items = response.data;
                             this.totalRows = this.items.length;
                       });

                    })
                    }
               })
               .catch(err => {
                 // An error occurred
               });
               this.addappMensaje=  " add successful";
         },
         editmodal(index){
         	this.formodifi.ID_app=index.ID_app;
        	this.formodifi.Name_app=index.Name_app;
		  	this.formodifi.Enable =(index.Enable == "1")?"true":"false";
		  	this.formodifi.Description = index.Description;
		  	this.formodifi.Version = index.Version ;
            this.$refs['updateapp'].show();
         },

         modaladdKoverall(){

         },
         async add_App (){
     	   if(this.formNewnapp.Name_app===""  ) {
   	  		   return 0;
  	  		}
             /* Initialize the form data */
             var formData = new FormData();
             /*  Add the form data we need to submit */
             formData.append('Name_app', this.formNewnapp.Name_app);
             formData.append('Enable', this.formNewnapp.Enable);
             formData.append('app_EXE', this.formNewnapp.app_EXE);
             formData.append('Description', this.formNewnapp.Description);
             formData.append('Version', this.formNewnapp.Version);
             /* Make the request to the POST ../../MoleculeTable URL */
             await axios.post( 'upAppsDesktop',formData,{
             headers: { 'Content-Type': 'multipart/form-data'}}
             ).then(response =>{
          	   	console.log(response.data);

             }
             )
             await axios.get('upAppsDesktop').then(response =>{
          	       	this.items = response.data;
          	       	this.totalRows = this.items.length;
          	 });

             this.$bvModal.hide('addapp');

         },

         async updateApp(){
             /* Initialize the form data */
             var formData = new FormData();
        	 formData.append('_method','PUT');
        	 formData.append('Name_app', this.formodifi.Name_app);
             formData.append('Enable', this.formodifi.Enable);
             formData.append('app_EXE', this.formodifi.app_EXE);
             formData.append('Description', this.formodifi.Description);
             formData.append('Version', this.formodifi.Version);
             /* Make the request to the POST ../../MoleculeTable URL */
             await axios.post( 'upAppsDesktop/'+this.formodifi.ID_app,formData,{
             headers: { 'Content-Type': 'multipart/form-data'}}
             ).then(response =>{
          	   	console.log(response.data);

             }
             )
             await axios.get('upAppsDesktop').then(response =>{
          	       	this.items = response.data;
          	       	this.totalRows = this.items.length;
          	 });
             this.$bvModal.hide('updateapp');

         },

         handleFileUpload(){
       	  this.formNewnapp.app_EXE = this.$refs.form_exe.files[0];
         },
         handleFileUploadUP(){
          	  this.formodifi.app_EXE = this.$refs.form_exe_UP.files[0];
         },
      }
});
