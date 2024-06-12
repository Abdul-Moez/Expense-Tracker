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

Route::get('/', 'LoginController@login')->name('login');
Route::get('/register', 'LoginController@register')->name('register');
Route::post('/login_process', 'LoginController@loginProcess')->name('login_process');

Route::group(['middleware' => ['normaluserlogin']], function () {

    Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

    Route::get('/dashboard/income', 'IncomeController@income')->name('income');
    Route::post('/income_process', 'IncomeController@incomeProcess')->name('income_process');

    Route::get('/dashboard/expense', 'ExpenseController@expense')->name('expense');
    Route::post('/expense_process', 'ExpenseController@expenseProcess')->name('expense_process');

    Route::get('/dashboard/bank_accounts', 'BankAccountsController@bankAccounts')->name('bank_accounts');
    Route::post('/bank_accounts_process', 'BankAccountsController@bankAccountsProcess')->name('bank_accounts_process');

    Route::get('/dashboard/category', 'CategoryController@category')->name('category');
    Route::post('/category_process', 'CategoryController@categoryProcess')->name('category_process');

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
