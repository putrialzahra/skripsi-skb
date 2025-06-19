<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalonPesertaDidikController;

Route::get('/', function () {
    return view('ppdb.form');
});

// Routes untuk PPDB
Route::get('/ppdb', [CalonPesertaDidikController::class, 'create'])->name('ppdb.create');
Route::post('/ppdb', [CalonPesertaDidikController::class, 'store'])->name('ppdb.store');


