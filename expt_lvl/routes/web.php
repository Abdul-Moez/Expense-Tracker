<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('registration');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/income', function () {
    return view('income');
});

Route::get('/expense', function () {
    return view('expense');
});

Route::get('/bank_accounts', function () {
    return view('bank_accounts');
});

Route::get('/category', function () {
    return view('category');
});