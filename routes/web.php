<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'home');
Route::view('/planes-estrategicos', 'planes-estrategicos/index');
Route::view('/reportes', 'reportes/index');
Route::view('/configuracion', 'configuracion/index');

//Route::get('/', function () {
//    return view('home');
//});

//Route::get('/planes-estrategicos', function () {
//    return view('planes-estrategicos.index');
//});

//Route::get('/reportes', function () {
//    return view('reportes.index');
//});
//
//Route::get('/configuracion', function () {
//    return view('configuracion.index');
//});
