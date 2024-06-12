<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;

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

    Route::get('/dashboard/income', [IncomeController::class, 'income'])->name('income');
    Route::post('/income_process', [IncomeController::class, 'incomeProcess'])->name('income_process');

    Route::get('/dashboard/expense', [ExpenseController::class, 'expense'])->name('expense');
    Route::post('/expense_process', [ExpenseController::class, 'expenseProcess'])->name('expense_process');

    Route::get('/dashboard/bank_accounts', [BankAccountsController::class, 'bankAccounts'])->name('bank_accounts');
    Route::post('/bank_accounts_process', [BankAccountsController::class, 'bankAccountsProcess'])->name('bank_accounts_process');

    Route::get('/dashboard/category', [CategoryController::class, 'category'])->name('category');
    Route::post('/category_process', [CategoryController::class, 'categoryProcess'])->name('category_process');

});

Route::get('/configcachecleared', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
//Clear Cache facade value:
Route::get('/clearcached', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});
Route::get('/clearviewed', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>Cache view value cleared</h1>';
});
