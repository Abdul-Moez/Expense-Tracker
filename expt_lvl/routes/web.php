<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BankAccountsController;

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

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login_process', [LoginController::class, 'loginProcess'])->name('login_process');

Route::group(['middleware' => ['normaluserlogin']], function () {


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/income', function () {
        return view('income');
    });

    Route::get('/expense', function () {
        return view('expense');
    });

    Route::get('/bank_accounts', function () {
        return view('bank_accounts');
    });

    Route::get('/bank_accounts', [BankAccountsController::class, 'bankAccounts'])->name('bank_accounts');
    Route::post('/bank_accounts_process', [BankAccountsController::class, 'bankAccountsProcess'])->name('bank_accounts_process');

    Route::get('/category', [CategoryController::class, 'category'])->name('category');
    Route::post('/category_process', [CategoryController::class, 'categoryProcess'])->name('category_process');

});