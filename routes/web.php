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

Route::get('/login', function () { return view('login.index');})->name('login');
Route::post('/login', 'LoginController@doLogin' )->name('do-login');


Route::group(['middleware' => ['auth']], function (){
    Route::get('/', 'DashboardController@index')->name('home');

//  auto complete feature
    Route::post('/product/autocomplete', 'SearchController@searchProduct')->name('product-autocomplete');
    Route::post('/customer/autocomplete', 'SearchController@searchCustomer')->name('customer-autocomplete');

//purchase routes
    Route::get('/product', 'ProductController@index')->name('product-view');
    Route::get('/product/add', 'ProductController@create')->name('product-insert-view');
    Route::get('/product/update/{id}', 'ProductController@edit')->name('product-update-view');

    Route::post('/product/add', 'ProductController@store')->name('product-insert');
    Route::post('/product/update/{id}', 'ProductController@update')->name('product-update');
    Route::post('/product/delete', 'ProductController@destroy')->name('product-delete');
    Route::post('/product/search', 'ProductController@show')->name('product-search');
    Route::post('/product/print/', 'ProductController@print')->name('product-print');


//purchase routes
    Route::get('/purchase', 'PurchaseHeaderController@index')->name('purchase-view');
    Route::get('/purchase/add', 'PurchaseHeaderController@create')->name('purchase-insert-view');
    Route::get('/purchase/{id}', 'PurchaseHeaderController@show')->name('purchase-detail-view');

    Route::post('/purchase/add', 'PurchaseHeaderController@store')->name('purchase-insert');
    Route::post('/purchase/paid/{id}', 'PurchaseHeaderController@paid')->name('purchase-paid');
    Route::post('/purchase/delete', 'PurchaseHeaderController@destroy')->name('purchase-delete');


//transaction route
    Route::get('/transaction', 'TransactionHeaderController@index')->name('transaction-view');
    Route::get('/transaction/{id}', 'TransactionHeaderController@show')->name('transaction-detail');
    Route::get('/transaction/print/{id}', 'TransactionHeaderController@print')->name('transaction-print');

    Route::post('/transaction/paid/{id}', 'TransactionHeaderController@paid')->name('transaction-paid');
    Route::post('/transaction/add', 'TransactionHeaderController@store')->name('transaction-insert');
    Route::post('/transaction/delete', 'TransactionHeaderController@destroy')->name('transaction-delete');
    Route::post('/transaction/search', 'TransactionHeaderController@search')->name('transaction-search');

//    category route
    Route::get('/category', 'CategoryController@index')->name('category-view');
    Route::get('/category/add', 'CategoryController@create')->name('category-insert-view');
    Route::get('/category/update/{id}', 'CategoryController@edit')->name('category-update-view');

    Route::post('/category/add', 'CategoryController@store')->name('category-insert');
    Route::post('/category/delete/{id}', 'CategoryController@destroy')->name('category-delete');
    Route::post('/category/update/{id}', 'CategoryController@update')->name('category-update');

//    customer route
    Route::get('/customer', 'CustomerController@index')->name('customer-view');
    Route::get('/customer/add', 'CustomerController@create')->name('customer-insert-view');
    Route::get('/customer/{id}', 'CustomerController@show')->name('customer-detail-view');
    Route::get('/customer/update/{id}', 'CustomerController@edit')->name('customer-update-view');

    Route::post('/customer/add', 'CustomerController@store')->name('customer-insert');
    Route::post('/customer/update/{id}', 'CustomerController@update')->name('customer-update');
    Route::post('/customer/delete/{id}', 'CustomerController@destroy')->name('customer-delete');
    Route::post('/customer/search', 'CustomerController@search')->name('customer-search');

//   reporting
    Route::get('/report', 'ReportController@index')->name('report-view');
    Route::get('/report/stock/month', 'ReportController@monthlyStockReport')->name('report-stock-monthly');

//    log out user
    Route::get('/logout', 'StaffController@logout')->name('logout');
});


