<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ExptUsers;
use App\Models\ExptBankAccounts;
use App\Models\ExptCategory;
use App\Models\ExptIncome;
use App\Models\ExptExpense;
Use DB;
Use Mail;
use Session;


class DashboardController extends BaseController{

    public function dashboard() {

        // dd(Crypt::encrypt('Test'));

        if(!session::has('normalUserId')){
            return redirect('/');
        };

        $monthlyIncome = ExptIncome::select('*')->where('user_id', session::get('normalUserId'));
        $monthlyExpense = ExptExpense::select('*')->where('user_id', session::get('normalUserId'));

        $totalMonthlyIncome = $monthlyIncome->whereMonth('date', date('m'))->get();
        $totalMonthlyExpense = $monthlyExpense->whereMonth('date', date('m'))->get();

        $totalMonthlyIncomeValue = 0;
        $totalMonthlyExpenseValue = 0;
        foreach ($totalMonthlyIncome as $rsTotalMonthlyIncome) {
            $totalMonthlyIncomeValue += Crypt::decrypt($rsTotalMonthlyIncome->amount);
        }

        foreach ($totalMonthlyExpense as $rsTotalMonthlyExpense) {
            $totalMonthlyExpenseValue += Crypt::decrypt($rsTotalMonthlyExpense->amount);
        }

        $totalIncome = ExptIncome::select('*')->where('user_id', session::get('normalUserId'))->get();
        $totalExpense = ExptExpense::select('*')->where('user_id', session::get('normalUserId'))->get();

        $totalIncomeValue = 0;
        $totalExpenseValue = 0;
        foreach ($totalIncome as $rsTotalIncome) {
            $totalIncomeValue += Crypt::decrypt($rsTotalIncome->amount);
        }

        foreach ($totalExpense as $rsTotalExpense) {
            $totalExpenseValue += Crypt::decrypt($rsTotalExpense->amount);
        }

        $recentIncome = ExptIncome::select('*')->where('expt_income.user_id', session::get('normalUserId'))->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_income.account_id')->orderBy('expt_income.id', 'DESC')->get(3);
        $recentExpense = ExptExpense::select('*')->where('expt_expense.user_id', session::get('normalUserId'))->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_expense.account_id')->join('expt_category','expt_category.id', '=', 'expt_expense.category_id')->orderBy('expt_expense.id', 'DESC')->get(3);

        $totalBalance = $totalIncomeValue - $totalExpenseValue;

        return view('dashboard', ['totalMonthlyExpenseValue' => $totalMonthlyExpenseValue, 'totalMonthlyIncomeValue' => $totalMonthlyIncomeValue, 'totalBalance' => $totalBalance, 'recentExpense' => $recentExpense, 'recentIncome' => $recentIncome]);
    }

}