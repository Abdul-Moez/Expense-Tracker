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

        $monthlyIncome = ExptIncome::select('*');
        $monthlyExpense = ExptExpense::select('*');

        $totalMonthlyIncome = $monthlyIncome->whereMonth('date', date('m'))->get();
        $totalMonthlyExpense = $monthlyExpense->whereMonth('date', date('m'))->get();

        $totalMonthlyIncomeValue = 0;
        $totalMonthlyExpenseValue = 0;
        foreach ($totalMonthlyIncome as $rsTotalMonthlyIncome) {
            $totalMonthlyIncomeValue += $this->decrypt($rsTotalMonthlyIncome->amount);
        }

        foreach ($totalMonthlyExpense as $rsTotalMonthlyExpense) {
            $totalMonthlyExpenseValue += $this->decrypt($rsTotalMonthlyExpense->amount);
        }

        $recentIncome = ExptIncome::select('*')->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_income.account_id')->orderBy('expt_income.id', 'DESC')->get(3);
        $recentExpense = ExptExpense::select('*')->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_expense.account_id')->join('expt_category','expt_category.id', '=', 'expt_expense.category_id')->orderBy('expt_expense.id', 'DESC')->get(3);

        $totalBalance = $totalMonthlyIncomeValue - $totalMonthlyExpenseValue;

        return view('dashboard', ['totalMonthlyExpenseValue' => $totalMonthlyExpenseValue, 'totalMonthlyIncomeValue' => $totalMonthlyIncomeValue, 'totalBalance' => $totalBalance, 'recentExpense' => $recentExpense, 'recentIncome' => $recentIncome]);
    }

    public Static function encrypt($value) {

        return Crypt::encrypt($value);

    }

    public static function decrypt($value) {

        return Crypt::decrypt($value);

    }

}