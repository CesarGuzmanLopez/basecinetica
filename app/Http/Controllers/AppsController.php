<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','role:admin,super-admin']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexApp()
    {
        return view('user/Apps/Apps_Desktop');
    }
}
