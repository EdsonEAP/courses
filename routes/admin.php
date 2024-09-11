<?php
    //rutas con respecto a administracion

    use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
