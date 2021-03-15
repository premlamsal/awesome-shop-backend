<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//frontend part
Route::group(['prefix'=>'frontend','as'=>'frontend.'], function(){
   
	//frontend part

		Route::group(['middleware' => ['cors', 'json.response']], function () {

			// public routes
		    Route::post('/login', 'Api\AuthController@login')->name('login.api');

		    Route::post('/register', 'Api\AuthController@register')->name('register.api');

			Route::get('/books','Api\BookController@index');

			Route::get('/sliders','SliderController@index');

			Route::get('/relatedBooks/{slug}','Api\BookController@relatedBooks');

			Route::get('/book/{id}','Api\BookController@show');

			Route::get('/category/{slug}','Api\BookController@browseByCategory');

			Route::get('/search/{key}','Api\BookController@browseBySearchKey');

			//pass the slug of book and get the book detail
			//DFS- book detail from slug
			Route::get('/bookDFS/{slug}','Api\BookController@getBookDetail');

			Route::get('categories','Api\CategoryController@index');

			Route::get('categories/random','Api\CategoryController@random');

			Route::get('units','Api\UnitController@index');
			
			Route::get('/getCategoriesMenu','Api\CategoryController@getCategoriesForMenu');

			Route::get('/checkstock/{id}','Api\BookController@checkStock');
		});



		Route::get('/getmenu','Api\MenuController@show2');

		Route::middleware('auth:api')->group(function () {

		    // our routes to be protected will go in here
		    Route::post('/logout', 'Api\AuthController@logout')->name('logout.api');

		});


		Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {

				Route::get('getUser','Api\UserController@show');

				Route::post('updateUser','Api\UserController@update');
				
				Route::get('getUserTransaction','Api\UserController@userTransaction');

				Route::post('withDrawRequest','Api\UserController@withDrawRequest');

				Route::get('checkIfWithDrawRequested','Api\UserController@checkIfWithDrawRequested');

				Route::get('loadMyBooks','Api\UserController@loadMyBooks');

				Route::post('uploadBook','Api\BookController@store');

				Route::post('editBook','Api\BookController@update');

				Route::get('loadBook','Api\BookController@show');

				Route::post('review','Api\ReviewController@store');

				Route::post('cart/check','CartController@check');

				Route::post('verify/esewa','PaymentVerificationController@verifyEsewa');

				Route::post('verify/khalti','PaymentVerificationController@verifyKhalti');

		});
});




//admin part
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
   
	//admin part
	// public routes
	Route::post('/login', 'Admin\AuthController@login');

		Route::group(['middleware' => ['cors', 'json.response','auth:api']], function () {

		
			Route::get('/users', 'Admin\UserController@users');
			Route::get('/books','Api\BookController@index');

			Route::get('/transactions','Admin\TransactionController@index');

			Route::get('/transaction/{id}','Admin\TransactionController@show');

			Route::post('/transaction/status','Admin\TransactionController@status');

			Route::get('/sliders','SliderController@index');

			Route::post('/slider','SliderController@store');

			Route::put('/slider','SliderController@update');

			Route::delete('/slider/{id}','SliderController@delete');

			Route::get('/slider/{id}','SliderController@show');


						//List Units
			Route::get('units','UnitController@index');

			//List single Unit
			Route::get('units/{id}','UnitController@show');

			//Add Unit
			Route::post('unit','UnitController@store');

			//Update Unit
			Route::put('unit','UnitController@update');

			//Delete Unit
			Route::delete('unit/{id}','UnitController@destroy');

			//Search units
			Route::post('units/search','UnitController@searchUnits');

			

			//List Categories
			Route::get('categories','CategoryController@index');

			//List single Category
			Route::get('categories/{id}','CategoryController@show');

			//Add Category
			Route::post('category','CategoryController@store');

			//Update Category
			Route::put('category','CategoryController@update');

			//Delete Category
			Route::delete('category/{id}','CategoryController@destroy');

			//Search Category
			Route::post('categories/search','CategoryController@searchCategories');

		
			//Dashboard Information
			Route::get('/dashboard/info/','DashboardController@info');

		});
		Route::middleware('auth:api')->group(function () {

		    // our routes to be protected will go in here
		    Route::post('/logout', 'Admin\AuthController@logout')->name('logout.api');

		});

});
