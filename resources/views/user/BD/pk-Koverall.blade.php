@extends('home')

@section('userCont') 
<div id="aux">
<b-container fluid>
	<div class="row">
      <div class="col-12 col-md-4 py-5">
        <b-card title="Molecules" body-class="text-center" header-tag="nav">
          <template v-slot:header>
            <b-nav card-header tabs>
              <b-nav-item active>General</b-nav-item>
              <b-nav-item>Details</b-nav-item>
          </template>
          <b-card-text> 
               Table containing all the molecules for the database of k_overalls and pk's
          </b-card-text>
          <b-button variant="secondary" href="{{url('ModifyBD/DB-pk-Koverall/Molecules')}}">Modify</b-button>
        </b-card>
      </div>
            <div class="col-12 col-md-4 py-5">
        <b-card title="Solvents" body-class="text-center" header-tag="nav">
          <template v-slot:header>
            <b-nav card-header tabs>
              <b-nav-item active>General</b-nav-item>
              <b-nav-item>Details</b-nav-item>
            </b-nav>
          </template>
          <b-card-text> 
               Table containing all the Solvents for the database of k_overalls and pk's
          </b-card-text>
          <b-button variant="secondary" href="{{url('ModifyBD/DB-pk-Koverall/Solvents')}}">Modify</b-button>
        </b-card>
      </div>
       <div class="col-12 col-md-4 py-5">
        <b-card title="Radicals" body-class="text-center" header-tag="nav">
          <template v-slot:header>
            <b-nav card-header tabs>
              <b-nav-item active>General</b-nav-item>
              <b-nav-item>Details</b-nav-item>
            </b-nav>
          </template>
          <b-card-text> 
               Table containing all the Radicals for the database of k_overalls and pk's
          </b-card-text>
          <b-button variant="secondary" href="{{url('ModifyBD/DB-pk-Koverall/Radicals')}}">Modify</b-button>
        </b-card>        
      </div>
	</div>
   <br/>
   <div class="row">
      <div class="col-12 col-md-4 py-5">
        <b-card title="References" bg-variant="success" text-variant="white" header="Success" class="text-center">
          <template v-slot:header>
            <b-nav card-header tabs>
              <b-nav-item active>General</b-nav-item>
              <b-nav-item>Details</b-nav-item>
            </b-nav>
          </template>
          <b-card-text> 
               Table containing all the References literal for the database of k_overalls and pk's
          </b-card-text>
          <b-button variant="primary" href="{{url('ModifyBD/DB-pk-Koverall/References')}}">Modify</b-button>
        </b-card>
      </div>
            <div class="col-12 col-md-4 py-5" >
        <b-card title="PK's" body-class="text-center" bg-variant="light" header="Light" header-tag="nav">
          <template v-slot:header>
            <b-nav card-header tabs>
              <b-nav-item active>General</b-nav-item>
              <b-nav-item>Details</b-nav-item>
            </b-nav>
          </template>
          <b-card-text> 
               Table containing all the PK's for the database of k_overalls and pk's
          </b-card-text>
          <b-button variant="primary" href="{{url('ModifyBD/DB-pk-Koverall/PK_s')}}">Modify</b-button>
        </b-card>
        
       
      </div>
       <div class="col-12 col-md-4 py-5">
        <b-card title="K Overalls" body-class="text-center"  bg-variant="light" header="Light" header-tag="nav">
          <template v-slot:header>
            <b-nav card-header tabs>
              <b-nav-item active>General</b-nav-item>
              <b-nav-item>Details</b-nav-item>
            </b-nav>
          </template>
          <b-card-text> 
               Table containing all the K Overalls for the database of k_overalls and pk's
          </b-card-text>
          <b-button variant="primary" href="{{url('ModifyBD/DB-pk-Koverall/K_overall')}}">Modify</b-button>
        </b-card>        
      </div>
   </div>

</b-container>
</div>
@endsection