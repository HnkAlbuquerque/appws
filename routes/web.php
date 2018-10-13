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

Route::get('/', function () {
    return view('welcome');
});

/*// LOGIN CONTROLLLER
Route::post('/loginapp','LoginController@index');
/////////////////////

/// GENERAL CONTROLLER
Route::get('/general/getcampos','GeneralController@getCampos');
Route::get('/general/gettiposlocais','GeneralController@getTiposLocais');
Route::get('/general/getlocais/{tipoInstituicao}/{idcampo}','GeneralController@getLocais');
Route::get('/general/getmembros/{param}','GeneralController@getMembros');
Route::get('/general/getnttipo','GeneralController@getNttipo');
Route::get('/general/getigrejas/{idcampo}','GeneralController@getIgrejas');
Route::get('/general/getgideoes/{param}','GeneralController@getGideao');
/////////////////////

/// DISTRIBUIÇÃO CONTROLLER
Route::post('distribuicao/insert','DistribuicaoController@insert');
/////////////////////

/// VISITAS CONTROLER
Route::post('visita/insert','VisitaController@insert');
///////////////////*/
