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
Route::get('/forgot_password.htm', 'LoginController@forgotPassword')->name('forgot_password');
Route::get('/reset_password/{link}', 'LoginController@resetPassword')->name('reset_password');
Route::post('/login_process', 'LoginController@loginProcess')->name('login_process');

Route::post('/api/appApiRoute', 'AppApiController@loginProcess')->name('app_api_login_process');

Route::group(['middleware' => ['normaluserlogin']], function () {
    
    Route::get('/encryption_key', 'LoginController@generate_key')->name('generate_key');

    Route::group(['middleware' => ['normaluserkey']], function () {

        Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
        Route::post('/dash_process', 'DashboardController@dashProcess')->name('dashboard_process');

        Route::get('/dashboard/income', 'IncomeController@income')->name('income');
        Route::post('/income_process', 'IncomeController@incomeProcess')->name('income_process');

        Route::get('/dashboard/expense', 'ExpenseController@expense')->name('expense');
        Route::post('/expense_process', 'ExpenseController@expenseProcess')->name('expense_process');

        Route::get('/dashboard/bank_accounts', 'BankAccountsController@bankAccounts')->name('bank_accounts');
        Route::post('/bank_accounts_process', 'BankAccountsController@bankAccountsProcess')->name('bank_accounts_process');

        Route::get('/dashboard/category', 'CategoryController@category')->name('category');
        Route::post('/category_process', 'CategoryController@categoryProcess')->name('category_process');

    });
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
Route::get('/clearroute', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Cache route value cleared</h1>';
});