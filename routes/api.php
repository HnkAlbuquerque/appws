<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/// LOGIN CONTROLLLER
Route::post('/loginapp','LoginController@index');
Route::post('/loginappreval','LoginController@revalLogin');
/////////////////////

/// GENERAL CONTROLLER
Route::get('/general/getcampos/{param}','GeneralController@getCampos');
Route::get('/general/getgideoes/{param}','GeneralController@getGideao');
Route::get('/general/gettiposlocais','GeneralController@getTiposLocais');
Route::get('/general/getlocais/{tipoInstituicao}/{idcampo}','GeneralController@getLocais');
Route::get('/general/getmembros/{param}','GeneralController@getMembros');
Route::get('/general/getnttipo','GeneralController@getNttipo');
Route::get('/general/getigrejas/{idcampo}','GeneralController@getIgrejas');
Route::get('/general/getfeed','GeneralController@getFeed');
Route::get('/general/getnttipo/{new_as_cod}','GeneralController@getNttipo');
/////////////////////

/// DISTRIBUIÇÃO CONTROLLER
Route::post('distribuicao/insert','DistribuicaoController@insert');
/////////////////////

/// VISITAS CONTROLER
Route::post('visita/insert','VisitaController@insert');
////////////////////
