
if($("#compare_kO").length!=0)
var Compare_kO = new window.Vue({
    el: '#compare_kO',
    data() {
    	return {
    		fields: [
    			{ key:'Name', label: 'Molecule name', sortable: true, ID_Molecule:'ID_Molecule' },
    	        { key:'Name_Radical', label: 'Radical', sortable: true },
    	        { key:'Name_Solvent', label: 'Solvent', sortable: true },
    	        { key:'Valor', label: 'K Overall', sortable: true , variant: 'info'},
    	        { key:'pH', label:'pH', sortable: true },
    	        { key:'Tipo', label:'Type', sortable: true },
    	        { key:'Descripcion', label: 'Description'},
    	        { key:'Relation',label:'Relation',sortable:true,variant: 'warning' },
    	        { key : 'info',label:'info'},
    	    ],
    	    isBusy: false,
    	    totalRows: 1,
            currentPage: 1,
    	    filter: null,
            filterOn: ['Valor'],
            perPage: 15,
            sortBy: '',
            sortDesc: false,
            Molecules:[] ,
            ActSRad:[],
            ActSolv:[],
            Act_pH:[],
            MolSelected:"2",
            RadSelected:"1",
            SolSelected:"1",
            pH_Selected:"7.4",
            TypSelected:"All",
            sortDirection: 'asc',
    	    items: [],
    	    molToCompare:"Trolox",
    	    IDK_OveralComparation:14,
    	    ValorCompare :410000,
    	    userMol:"",
    	    userValue:0,

    	}
    },
    async mounted() {
    	// Set the initial number of items
    	this.totalRows = this.items.length
        var formData = new FormData();
        /*  Add the form data we need to submit */
        formData.append('appeal','Molecules');//peticion de datos
    	formData.append('IDSolvent',"1");
        formData.append('IDRadical',"1");
        formData.append('IDMolecule',"2");

     	formData.append('Type', "");
     	formData.append('pH', "7.4");
     	await axios.post('/getCompareK_O', formData).then((response) =>{
        	this.Molecules =response.data;
        });
        formData.delete('appeal');
        formData.append('appeal','Radicals');//peticion de datos
        await axios.post('/getCompareK_O', formData).then((response) =>{
        	this.ActSRad =response.data;
         });
        formData.delete('appeal');
        formData.append('appeal','Solvents');//peticion de datos
        await axios.post('/getCompareK_O', formData).then( (response) =>{
        	this.ActSolv =response.data;
         });

        formData.delete('appeal');
        formData.append('appeal','pH');//peticion de datos
        await  axios.post('/getCompareK_O', formData).then( (response) =>{
        	this.Act_pH =response.data;
         });
        formData.delete('appeal');
        formData.append('appeal','Const');//peticion de datos
        await axios.post('/getCompareK_O', formData).then( (response) =>{
        	this.items =response.data;

            this.molToCompare = this.items[1];

         });

    },
    computed: {},
    methods : {
    	changeMol(){
            this.ActSRad=[];
            this.ActSolv=[];
            this.Act_pH=[];
            this.items=[];
            this.RadSelected="";
            this.SolSelected="";
            this.pH_Selected="";
            var formData = new FormData();
            formData.append('pH',"7.4");
            formData.append('IDMolecule',this.MolSelected);
            formData.append('appeal','Radicals');
            axios.post('/getCompareK_O', formData).then((response) =>{
            	this.ActSRad =response.data;

             });

    	},
    	changeRad(){
    	    this.Act_pH=[];
            this.ActSolv=[];
            this.items=[];
            this.SolSelected="";
            this.pH_Selected="";
            var formData = new FormData();
            formData.append('IDMolecule',this.MolSelected);
            formData.append('IDRadical',this.RadSelected);
            formData.append('appeal','Solvents');
            axios.post('/getCompareK_O', formData).then((response) =>{
            	this.ActSolv =response.data;

              });
    	},
    	changeSol(){
    	       this.Act_pH=[];
            this.items=[];
            var formData = new FormData();
            formData.append('IDMolecule',this.MolSelected);
            formData.append('IDRadical',this.RadSelected);
            formData.append('IDSolvent',this.SolSelected);
            formData.append('appeal','pH');//peticion de datos
            axios.post('/getCompareK_O', formData).then( (response) =>{
            	this.Act_pH =response.data;
              });
    	},
    	changepH(){
            this.items=[];
            var formData = new FormData();
            formData.append('IDMolecule',this.MolSelected);
            formData.append('IDRadical',this.RadSelected);
            formData.append('IDSolvent',this.SolSelected);
            formData.append('Type',this.TypSelected);
            if(this.pH_Selected != null)

            	formData.append('pH',this.pH_Selected);
            else
            	formData.append('pH',"-1");
              formData.append('appeal','Const');//peticion de datos
            axios.post('/getCompareK_O', formData).then( (response) =>{
            	this.items =response.data;
              });

    	},

		 rowClass(item, type) {
		        if (!item || type !== 'row') return
		        if(item.ID_K_OVERALL == this.IDK_OveralComparation) return 'table-warning'
		        if (item.ID_Molecule ==this.MolSelected  ) return 'table-success'
		 }
    	,
    	RowClicked(item, index, event) {
    		if(this.IDK_OveralComparation !=item.ID_K_OVERALL )
    			this.IDK_OveralComparation = item.ID_K_OVERALL;
    		else
    			this.IDK_OveralComparation =-1;
    		this.molToCompare = item;
    		this.ValorCompare =parseFloat(" " + item.Valor);
    		this.userMol="";
    		this.userValue=0;

    	},
    	onFiltered(filteredItems) {
    	        // Trigger pagination to update the number of buttons/pages due to filtering
    	        this.totalRows = filteredItems.length
    	        this.currentPage = 1
    	 },
    },
});
