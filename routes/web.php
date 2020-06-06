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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/','HomeController@index');

//---LOGIN ADMIN---
Route::get('/admin/login','AuthController@login')->name('admin.login');
Route::post('/admin/postlogin', 'AuthController@postlogin')->name('admin.postLogin');
Route::get('/admin/logout', 'AuthController@logout')->name('admin.logout');

Route::get('/login','LoginController@login');
Route::post('/postlogin','LoginController@postlogin')->name('user.postLogin');
Route::post('/cart/tambah', 'CartController@tambah');
Route::post('/cart', 'CartController@index');
Route::get('/cart/delete/{id}', 'CartController@delete');
Route::get('/cart/get_province', 'CartController@get_province');
Route::get('/cart/kota/{id}', 'CartController@get_city');
Route::post('/cart/cekongkir', 'CartController@cekongkir');
Route::post('/cart/get_kota', 'CartController@get_kota');
Route::post('/cart/cekongkir', 'CartController@cekongkir');
Route::post('/cart/detail', 'CartController@detail');
Route::post('/cart/proses', 'CartController@proses');
Route::get('/profil', 'ProfilController@index');
Route::get('/profil/notification', 'NotificationController@index')->name('notification.user');
Route::get('/profil/cancel/{id}', 'ProfilController@cancel');
Route::post('/profil/buktibayar/{id}', 'ProfilController@buktibayar');
Route::post('/profil/review/{id}', 'ProfilController@review');
Route::get('/chartJson', 'AdminController@chart');
//----CRUD DATA PRODUCT DAN MIDDLEWARE---
Route::group(['middleware'=>'admin'], function (){
    Route::get('/products', 'ProductsController@index');//untuk mengarahkan ke /products
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::post('/products/create', 'ProductsController@create'); //untuk create atau menambahkan data
    Route::get('/products/{id}/edit', 'ProductsController@edit'); //untuk update atau edit
    Route::post('/products/{id}/update', 'ProductsController@update'); //menangkap data dari edit blade
    Route::get('/products/{id}/delete', 'ProductsController@delete'); //delete data
     Route::get('/products/{id}/lihat', 'ProductsController@lihat'); //delete data
    Route::get('/products/{id}/gambar', 'ProductsController@gambar');

    Route::get('/products/{id}/diskon', 'ProductsController@diskon');
    Route::post('/products/diskon_insert', 'ProductsController@diskon_insert');

    Route::get('/products/{id}/category', 'ProductsController@category');
    Route::post('/products/category_insert', 'ProductsController@category_insert');

    Route::resource('category', 'CategoryController')->except(['create', 'show']);
    Route::get('/transaksi', 'TransaksiController@index');
    Route::get('/transaksi/updatestatus/{id}', 'TransaksiController@updatestatus');
    Route::get('/review', 'ReviewController@index');
    Route::get('/review/input/{id}', 'ReviewController@input');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/lihatproduk', 'HomeController@lihatproduk');
Route::get('/produkdetail/{id}', 'HomeController@produkdetail');

Route::get('/cart', 'CartController@index');
