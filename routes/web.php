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


Route::middleware(['auth'])->group(function () {
	Route::get('/dashboard/users', 'Backend\AdminController@users')->name('dash_users');
	Route::get('/dashboard/update_user/{id}', 'Backend\AdminController@updateUser')->name('dash_update_user');
	Route::get('/dashboard/del_user/{id}', 'Backend\AdminController@deleteUser')->name('dash_del_user');
	Route::post('dashboard/store_user', 'Backend\AdminController@storeUser')->name('dash_store_user');
	Route::get('dashboard/register_user', function () { return view('backend.register_user'); })->name('dash_reg_user');

	Route::get('/dashboard/investors', 'Backend\InvestController@investors')->name('dash_investors');
	Route::get('/dashboard/update_investor/{id}', 'Backend\InvestController@updateInvestor')->name('dash_update_investor');
	Route::get('/dashboard/del_investor/{id}', 'Backend\InvestController@deleteInvestor')->name('dash_del_investor');
	Route::post('dashboard/store_investor', 'Backend\InvestController@storeInvestor')->name('dash_store_investor');
	Route::get('dashboard/register_investor', function () { return view('backend.register_investor'); })->name('dash_reg_investor');

	Route::get('/dashboard/show_invests/{id}', 'Backend\InvestController@showInvest')->name('dash_show_invests');
	Route::get('/dashboard/update_solve/{id}/{accept}', 'Backend\InvestController@updateSolve')->name('dash_update_solve');
	Route::get('/dashboard/update_invest/{id}', 'Backend\InvestController@updateInvest')->name('dash_update_invest');
	Route::get('/dashboard/del_invest/{id}', 'Backend\InvestController@deleteInvest')->name('dash_del_invest');
	Route::get('dashboard/add_invest/{id}', 'Backend\InvestController@addInvest')->name('dash_add_invest');
	Route::post('dashboard/store_invest', 'Backend\InvestController@storeInvest')->name('dash_store_invest');
	
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
