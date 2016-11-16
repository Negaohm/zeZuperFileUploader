<?php
/**
 * @var $router \Illuminate\Routing\Router
 */
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
$router->resource('image','ImageController',["except"=>["store"]]);
$router->get('/image/{$image}/raw',["as"=>"image.raw","uses"=>'ImageController@raw']);
$router->post('/upload/image','UploadController@upload');
$router->get('/home',["as"=>"home","uses"=>"HomeController@home"]);
$router->get('/',["as"=>"welcome","uses"=>"HomeController@welcome"]);