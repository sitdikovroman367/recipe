<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('recipes', 'RecipeController');
Route::resource('ingredients', 'IngredientController');

//Route::resource('ingredients', 'IngredientController');
Route::post('storeAjax', 'IngredientController@storeAjax');
Route::delete('/recipes/{id}/destroyRelation', 'RecipeController@destroyRelation');
Route::post('/recipes/{id}/updateAmount', 'RecipeController@updateAmount');



