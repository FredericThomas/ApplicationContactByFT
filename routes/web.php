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
/*Route::get('/contactliste', function () {
    return view('liste_contact');
});*/
Route::get('demoo', 'Contact@CreateContactRandom'); 
Route::get('contactliste', 'Contact@ListeContact'); 
Route::get('xlsxdll', 'Contact@ExportXlsX'); 
Route::get('contactfiche', 'Contact@FicheContact'); 
Route::post('contactfiche', 'Contact@FicheContact'); 
Route::post('contactfichesave', 'Contact@EnregistrerContact');