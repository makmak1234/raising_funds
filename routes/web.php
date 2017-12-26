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
	Route::group(['prefix' => 'dashboard'], function () {
		Route::get('users', 'Backend\AdminController@users')->name('dash_users');
		Route::get('update_user/{id}', 'Backend\AdminController@updateUser')->name('dash_update_user');
		Route::get('del_user/{id}', 'Backend\AdminController@deleteUser')->name('dash_del_user');
		Route::post('store_user', 'Backend\AdminController@storeUser')->name('dash_store_user');
		Route::get('register_user', function () { return view('backend.register_user'); })->name('dash_reg_user');

		Route::get('investors', 'Backend\InvestController@investors')->name('dash_investors');
		Route::get('update_investor/{id}', 'Backend\InvestController@updateInvestor')->name('dash_update_investor');
		Route::get('del_investor/{id}', 'Backend\InvestController@deleteInvestor')->name('dash_del_investor');	
		Route::get('register_investor', function () { return view('backend.register_investor'); })->name('dash_reg_investor');

		Route::get('show_invests/{id}', 'Backend\InvestController@showInvest')->name('dash_show_invests');
		Route::get('add_invest/{id}', 'Backend\InvestController@addInvest')->name('dash_add_invest');
		Route::get('update_solve/{id}/{accept}', 'Backend\InvestController@updateSolve')->name('dash_update_solve');
		Route::get('update_invest/{id}', 'Backend\InvestController@updateInvest')->name('dash_update_invest');
		Route::get('del_invest/{id}', 'Backend\InvestController@deleteInvest')->name('dash_del_invest');

		Route::group(['prefix' => 'invates'], function () {
			Route::get('{message?}', 'Backend\InvatesController@invatesInvestors')->name('dash_invates');
			Route::get('error/{send_email?}/{send_sms?}', 'Backend\InvatesController@invatesErrorInvestors')->name('dash_invates_error');
			Route::post('send', 'Backend\InvatesController@invatesStore')->name('dash_send_invates');
			Route::get('view/email/{text_email}', 'Backend\InvatesController@emailView')->name('dash_email_view');
		});
	});
	
});

Route::group(['middleware' => ['auth_or_frontend']], function () {
	Route::post('dashboard/store_invest', 'Backend\InvestController@storeInvest')->name('dash_store_invest');
	Route::post('dashboard/store_investor', 'Backend\InvestController@storeInvestor')->name('dash_store_investor');
	Route::get('/private/register_investor', function () { return view('frontend.register_investor'); })->name('priv_reg_investor');
});

Route::group(['middleware' => ['frontend']], function () {
	Route::group(['prefix' => 'private'], function () {
		Route::post('logout', 'Frontend\InvestorsController@privateLogout')->name('priv_logout');
		
		Route::get('show_invests/{id}/{id_form?}', 'Frontend\InvestorsController@showInvest')->name('front_show_investor');
		Route::get('add_invest/{id}', 'Frontend\InvestorsController@addInvest')->name('priv_add_invest');
	});
});

Route::get('/private/auth_investor', function () {return view('frontend.auth_investor');})->name('priv_auth_investor');
Route::get('/private/hash_investor/{hash?}', 'Frontend\InvestorsController@hashInvestor')->name('priv_hash_investor');
Route::match(['get', 'post'], '/private/check_investor', 'Frontend\InvestorsController@checkInvestor')->name('priv_check_investor');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {return view('test.test');});
