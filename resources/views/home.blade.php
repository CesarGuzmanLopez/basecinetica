<?php use Illuminate\Support\Facades\DB;?>

@extends('layouts.app')
@section('content')

@if(Auth::user()->hasRole('admin'))

@endif 
<div class="page-wrapper chiller-theme
   @if(Request::route()->getName() =='home' )
      toggled
   @endif"> 
  <a id="show-sidebar" class="btn btn-sm btn-dark  " href="#">
    <i class="fa fa-bars"></i>
  </a>
  <div class="">
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <span class="col-11 text-info">Control Panel </span>
        <div id="close-sidebar">
          <i class="fa fa-times float-right"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <a href="{{url('home')}}">
        <div class="user-pic">
           <img class="img-responsive img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
            alt="User picture">
        </div>
        <div class="user-info">
          {{auth()->user()->name}}
          <span class="user-role">{{auth()->user()->getRollStr()}}</span>

        </div>
        </a>
      </div>
      <!-- sidebar-header  -->
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul>
          <li class="header-menu">
            <span>General</span>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-cogs"></i>
              <span>Dashboard</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Profile <i class="fa fa-user-cicle"></i>
                   </a>
                  <a href="#">contributions</a>
                </li>
              </ul>
            </div>
          </li>
          <!-- @if(auth()->user()->hasAnyRole(["super-admin","admin"]))-->

          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-database"></i>
              <span>Data base</span>
              <span class="badge badge-pill badge-danger">modify</span>
            </a>
            <!-- submenu -->
	        <?php  
	         $databases= DB::table('data_bases_q_s')->get();    
	      	?>
            <div class="sidebar-submenu">
               <ul>
	        <!--@foreach ($databases as $DB)-->
	              <li>
                     <a href="{{url('/ModifyBD/'.$DB->Name.'')}}"> {{$DB->Name}}
                     </a>
                  </li>
	         <!--@endforeach-->
                </ul>
            </div>
          </li>
           <!--@endif-->
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-file-code-o"></i>
              <span>Components</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
           	       <a href="{{url('/Up-Apps-Desktop') }}">
            		  <i class="fa fa-building "></i>
              		  <span>Programs</span>
            	    </a>
                </li>
                <li>
                  <a href="#">Articles</a>
                </li>
                <li>
                  <a href="#">Tables</a>
                </li>
              </ul>
            </div>
          </li>
  
          <!-- header menu
          <li class="header-menu">
            <span>Data base</span>
          </li>
          -->
        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
  </nav>
  </div>
  <!-- sidebar-wrapper  -->
  <main class="page-content">
    <div class="container-fluid"> 
      @section('userCont')       
      @show
    </div>
  </main>
  <!-- page-content" -->
</div>
    
@endsection


