<?php

use Illuminate\Support\Facades\Route;

Route::get('/inicio', function () {
    return view('home');
});

Route::get('/planes-estrategicos', function () {
    return view('planes-estrategicos.index');
});

Route::get('/reportes', function () {
    return view('reportes.index');
});

Route::get('/configuracion', function () {
    return view('configuracion.index');
});
