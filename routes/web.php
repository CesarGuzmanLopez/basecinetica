<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/','PrincipalController@index');
Route::get('/Kinetics', 'PrincipalController@BDKinetics');
Route::get('/Apps-Desktop', 'PrincipalController@Apps_Desktop');
Route::apiResource('/getMolecules','View_DATABASE\MoleculesController');
Route::apiResource('/getCompareK_O','View_DATABASE\CompareK_O');
Route::apiResource('/getApps','View_DATABASE\Apps');
Route::apiResource('/KOverals','View_DATABASE\KOverals');
Route::apiResource('/PK_S','View_DATABASE\PK_S');
Route::get("/Kinetics/relative-k-overall","PrincipalController@relative_k_overall");
Auth::routes(['verify' => true]);
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
//base de datos  pk's y K overalls

Route::get('/ModifyBD/DB-pk-Koverall','DB_pk_koverall_Controller@DB_pk_Koverall')->name('DB_pk_Koverall');
Route::get('/ModifyBD/DB-pk-Koverall/Molecules','DB_pk_koverall_Controller@Molecules')->name('Molecules');
Route::get('/ModifyBD/DB-pk-Koverall/Solvents','DB_pk_koverall_Controller@Solvents')->name('Solvents');
Route::get('/ModifyBD/DB-pk-Koverall/Radicals','DB_pk_koverall_Controller@Radicals')->name('Radicals');
Route::get('/ModifyBD/DB-pk-Koverall/References','DB_pk_koverall_Controller@References')->name('References');
Route::get('/ModifyBD/DB-pk-Koverall/PK_s','DB_pk_koverall_Controller@PK_s')->name('PK_s');
Route::get('/ModifyBD/DB-pk-Koverall/K_overall','DB_pk_koverall_Controller@K_overall')->name('K_overall');

Route::get('/Up-Apps-Desktop','AppsController@indexApp')->name('Apps Desktop');

Route::apiResource('/upAppsDesktop','ABC_DATABASE\App_Desktop_Table')->middleware(['auth','role:admin,super-admin']);

Route::apiResource('/MoleculeTable','ABC_DATABASE\MoleculeTable')->middleware(['auth','role:admin,super-admin']);
Route::apiResource('/SolventsTable','ABC_DATABASE\SolventsTable')->middleware(['auth','role:admin,super-admin']);
Route::apiResource('/RadicalsTable','ABC_DATABASE\RadicalsTable')->middleware(['auth','role:admin,super-admin']);
Route::apiResource('/ReferencesTable','ABC_DATABASE\ReferencesTable')->middleware(['auth','role:admin,super-admin']);
Route::apiResource('/PK_sTable','ABC_DATABASE\PK_sTable')->middleware(['auth','role:admin,super-admin']);
Route::apiResource('/K_overalsTable','ABC_DATABASE\K_overalsTable')->middleware(['auth','role:admin,super-admin']);
