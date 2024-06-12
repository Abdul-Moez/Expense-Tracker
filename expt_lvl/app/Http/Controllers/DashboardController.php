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
use App\ASPLibraries\CustomFunctions;
Use DB;
Use Mail;
use Session;

class DashboardController extends BaseController{

    public function dashboard() {

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
            $totalMonthlyIncomeValue += CustomFunctions::customDecrypt($rsTotalMonthlyIncome->amount, Session::get('normalUserEncryptKey'));
        }

        foreach ($totalMonthlyExpense as $rsTotalMonthlyExpense) {
            $totalMonthlyExpenseValue += CustomFunctions::customDecrypt($rsTotalMonthlyExpense->amount, Session::get('normalUserEncryptKey'));
        }

        $totalIncome = ExptIncome::select('amount')->where('user_id', session::get('normalUserId'))->get();
        $totalExpense = ExptExpense::select('amount')->where('user_id', session::get('normalUserId'))->get();

        $totalIncomeValue = 0;
        $totalExpenseValue = 0;
        foreach ($totalIncome as $rsTotalIncome) {
            $totalIncomeValue += CustomFunctions::customDecrypt($rsTotalIncome->amount, Session::get('normalUserEncryptKey'));
        }

        foreach ($totalExpense as $rsTotalExpense) {
            $totalExpenseValue += CustomFunctions::customDecrypt($rsTotalExpense->amount, Session::get('normalUserEncryptKey'));
        }

        // dd($recentTransactions);

        $recentIncome = ExptIncome::select('*')->where('expt_income.user_id', session::get('normalUserId'))->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_income.account_id')->orderBy('expt_income.id', 'DESC')->get(3);
        $recentExpense = ExptExpense::select('*')->where('expt_expense.user_id', session::get('normalUserId'))->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_expense.account_id')->join('expt_category','expt_category.id', '=', 'expt_expense.category_id')->orderBy('expt_expense.id', 'DESC')->get(3);

        $totalBalance = $totalIncomeValue - $totalExpenseValue;

        return view('dashboard', ['totalMonthlyExpenseValue' => $totalMonthlyExpenseValue, 'totalMonthlyIncomeValue' => $totalMonthlyIncomeValue, 'totalBalance' => $totalBalance, 'recentExpense' => $recentExpense, 'recentIncome' => $recentIncome]);
    }

    public function dashProcess(Request $request) {

        $userName = trim($request->updateUserProfName_val);
        $userEmail = trim($request->updateUserProfEmail_val);
        $currPassword = trim($request->updateUserProfCurPass_val);
        $newPassword = trim($request->updateUserProfNewPass_val);
        $cnfrmNewPassword = trim($request->updateUserProfCnfrmNewPass_val);

        if($userName != '') {
            ExptUsers::where('id', session::get('normalUserId'))->update(array('user_name' => $userName));
            session::forget('normalUserName');
            session::put('normalUserName', $userName);
        }else{
            return 'name empty';
        }

        if($userEmail != '') {
            ExptUsers::where('id', session::get('normalUserId'))->update(array('user_email' => $userEmail));
            session::forget('normalUserEmail');
            session::put('normalUserEmail', $userEmail);
        }else{
            return 'name empty';
        }

        if ($currPassword != '' && $newPassword == '' && $cnfrmNewPassword == '') {
            return 'new password and confirm new password';
        }
        if ($currPassword == '' && $newPassword != '' && $cnfrmNewPassword == '') {
            return 'current password and confirm new password';
        }
        if ($currPassword == '' && $newPassword == '' && $cnfrmNewPassword != '') {
            return 'current password and new password';
        }
        if ($currPassword == '' && $newPassword != '' && $cnfrmNewPassword != '') {
            return 'curr pass empty';
        }
        if ($currPassword != '' && $newPassword == '' && $cnfrmNewPassword != '') {
            return 'cnfrm pass empty';
        }
        if ($currPassword != '' && $newPassword == '' && $cnfrmNewPassword != '') {
            return 'new pass empty';
        }
        if($currPassword != '' && $newPassword != '' && $cnfrmNewPassword != '') {
            $userCurrPass = ExptUsers::select('user_password')->where('id', session::get('normalUserId'))->first();
            if ($userCurrPass->user_password == md5($newPassword) && $userCurrPass->user_password == md5($cnfrmNewPassword)) {
                return 'pass same as old pass';
            }
            ExptUsers::where('id', session::get('normalUserId'))->update(array('user_password' => md5($cnfrmNewPassword)));
        }

        return 'updated';

    }

}