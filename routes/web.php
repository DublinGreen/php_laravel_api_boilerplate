<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::post(env('PREFIX') . 'user/login', 'UserController@login');
Route::post(env('PREFIX') . 'admin/login', 'AdminController@login');
Route::get(env('PREFIX') . 'user/logout', 'UserController@logout');
Route::get(env('PREFIX') . 'admin/logout', 'AdminController@logout');


Route::group(['prefix'=> env('PREFIX'),'as'=>'user.','middleware' => ['auth']], function(){
    Route::get('user', 'UserController@index');
    Route::get('user/{id}', 'UserController@getById');
    Route::delete('user/{id}', 'UserController@delete');
    Route::get('user/orders/{id}', 'UserController@orders');
    Route::put('user/edit/{id}', 'UserController@edit');
    Route::post('user/create', 'UserController@create');
    Route::post('user/forgot-password', 'UserController@forgotPassword');
    Route::post('user/reset-password-token', 'UserController@resetPasswordToken');

    Route::get('admin/user-listing', 'AdminController@index');
    Route::post('admin/create', 'AdminController@create');
    Route::post('admin/user-edit/{id}', 'AdminController@edit');
    Route::post('admin/user-delete/{id}', 'AdminController@delete');

    Route::get('main/blog', 'MainController@blog');
    Route::get('main/blog/{id}', 'MainController@blogById');
    Route::get('main/promotions', 'MainController@promotions');

    Route::get('brand/blog', 'BrandController@brands');
    Route::post('brand/create', 'BrandController@create');
    Route::put('brand/{id} ', 'BrandController@edit');
    Route::get('brand/{id}', 'BrandController@brandById');
    Route::delete('brand/{id} ', 'BrandController@brandById');

    Route::get('categories/blog', 'CategoryController@categories');
    Route::post('category/create', 'CategoryController@create');
    Route::put('category/{id} ', 'CategoryController@edit');
    Route::get('category/{id}', 'CategoryController@categoryById');
    Route::delete('category/{id} ', 'CategoryController@categoryById');

    Route::post('product/create', 'ProductController@create');
    Route::put('product/{id}', 'ProductController@edit');
    Route::delete('product/{id} ', 'ProductController@delete');
    Route::get('product/{id}', 'ProductController@productById');
    Route::get('products', 'ProductController@products');

    Route::get('payments', 'PaymentController@payments');
    Route::post('payments/create', 'PaymentController@create');
    Route::get('payments/{id}', 'PaymentController@paymentById');
    Route::put('payments/{id}', 'PaymentController@edit');
    Route::delete('payments/{id} ', 'PaymentController@delete');

    Route::get('order-status', 'OrderStatusController@orderStatuses');
    Route::post('order-status/create', 'OrderStatusController@create');
    Route::get('order-status/{id}', 'OrderStatusController@orderStatusById');
    Route::put('order-status/{id}', 'OrderStatusController@edit');
    Route::delete('order-status/{id} ', 'OrderStatusController@delete');
});
