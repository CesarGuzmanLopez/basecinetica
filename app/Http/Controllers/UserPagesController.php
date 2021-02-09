<?php
namespace App\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class UserPagesController extends Controller{
	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	public $rolUser="invitado";
	protected $redirectTo = '/home';
	
	/**
	 * Create a new controller instance.
	 *
	 */
	
	public function __construct()
	{
 		$this->middleware('auth');
	}
	public function index(){
		if(Auth::user()->hasRole('super-admin')){
			$this->rolUser="super-admin";
			$this->vistaRoot();
		}
		if(Auth::user()->hasRole('admin')){
			$this->rolUser="admin";
			$this->VistaAdministrador();
		}
		if(Auth::user()->hasRole('user')){
			$this->rolUser="user";
			$this->vistaUser();
		}else{
		
			$this->rolUser="other";
			$this->vistaother();
		}
	}
	
	private function VistaAdministrador(){
		 
	}
	private function vistaRoot(){
		
	}
	private function vistaUser(){
		echo"";
	}
	private function vistaother(){
		
	}

}