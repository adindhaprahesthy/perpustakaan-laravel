<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kelascontroller;
use App\Http\Controllers\Siswacontroller;
use App\Http\Controllers\Bukucontroller;
use App\Http\Controllers\PeminjamanBukucontroller;
use App\Http\Controllers\PengembalianBukucontroller;
use App\Http\Controllers\DetailPeminjamanBukucontroller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

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

    
    Route::post("/register", [UserController::class, 'register']);
    Route::post("/login", [UserController::class, 'login']);
    Route::get('/login_check','UserController@getAuthenticatedUser');

    Route::group(['middleware' => ['jwt.verify']], function (){
    Route::get('/login_check','UserController@getAuthenticatedUser');


    Route::group(['middleware' => ['api.superadmin']], function()
        {
            Route::delete('/Kelasmodel/{id}', 'KelasController@destroy');
            Route::delete('/Siswamodel/{id}', 'SiswaController@destroy');
            Route::delete('/Bukumodel/{id}', 'BukuController@destroy');
            Route::delete('/PeminjamanBukumodel/{id}', 'PeminjamanBukuController@destroy');
            Route::delete('PengembalianBukumodel/{id}', 'PengembalianBukuController@destroy');
            Route::delete('/DetailPeminjamanBukumodel/{id}', 'DetailPeminjamanBukuController@destroy');

          
   });
        
    Route::group(['middleware'=> ['api.admin']], function()
        {    
            Route::post('/Kelasmodel', 'KelasController@store');
            Route::put('/Kelasmodel/{id}', 'KelasController@update');

            Route::post('/Siswamodel/UploadCoverSiswa/{id}', 'SiswaController@UploadCoverSiswa');
            Route::post('/Siswamodel', 'SiswaController@store');
            Route::put('/Siswamodel/{id}', 'SiswaController@update');

            Route::post('/Bukumodel/UploadCoverBuku/{id}', 'BukuController@UploadCoverBUku');
            Route::post('/Bukumodel', 'BukuController@store');
            Route::put('/Bukumodel/{id}', 'BukuController@update');

            Route::post('/PeminjamanBukumodel', 'PeminjamanBukuController@store');
            Route::put('/PeminjamanBukumodel/{id}', 'PeminjamanBukuController@update');

            Route::post('/PengembalianBukumodel', 'PengembalianBukuController@store');
            Route::put('/PengembalianBukumodel/{id}', 'PengembalianBukuController@update');

            Route::post('/DetailPeminjamanBukumodel', 'DetailPeminjamanBukuController@store');
            Route::put('/DetailPeminjamanBukumodel/{id}', 'DetailPeminjamanBukuController@update');
            
            

    });
    
            Route::get('/Kelasmodel', 'KelasController@show');
            Route::get('/Kelasmodel/{id}', 'KelasController@detail');

            Route::get('/Siswamodel', 'SiswaController@show');
            Route::get('/Siswamodel/{id}', 'SiswaController@detail');    
            
            Route::get('/Bukumodel', 'BukuController@show');
            Route::get('/Bukumodel/{id}', 'BukuController@detail');

            Route::get('/PeminjamanBukumodel', 'PeminjamanBukuController@show');
            Route::get('/PeminjamanBukumodel/{id}', 'PeminjamanBukuController@detail');    

            Route::get('/PengembalianBukumodel', 'PengembalianBukuController@show');
            Route::get('/PengembalianBukumodel/{id}', 'PengembalianBukucontroller@detail');

            Route::get('/DetailPeminjamanBukumodel', 'DetailPeminjamanBukuController@show');
            Route::get('/DetailPeminjamanBukumodel/{id}', 'DetailPeminjamanBukuController@detail');    
            
        });
        Route::post('/pinjam_buku','transaksicontroller@pinjamBuku');
        Route::post('/tambah_item/{id}','transaksicontroller@tambahItem');
        Route::post('/mengembalikan_buku','transaksiController@mengembalikanBuku');
        
        

         

            
   
