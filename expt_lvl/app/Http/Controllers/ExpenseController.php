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

class ExpenseController extends BaseController{

    public function expense() {

        if(!session::has('normalUserId')){
            return redirect('/');
        };

        $expenseList = ExptExpense::select('expt_expense.id', 'expt_bank_accounts.account_name', 'expt_category.category_name', 'expt_expense.amount', 'expt_expense.description', 'expt_expense.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_expense.account_id')
                                        ->join('expt_category', 'expt_category.id', '=', 'expt_expense.category_id')
                                        ->where('expt_expense.user_id', session::get('normalUserId'))
                                        ->where('expt_category.user_id', session::get('normalUserId'))
                                        ->where('expt_bank_accounts.user_id', session::get('normalUserId'))
                                        ->orderBy('expt_expense.id', 'DESC')
                                        ->get();

        $totalExpense = 0;
                                        
        foreach ($expenseList as $rsExpenseList):
            $totalExpense += CustomFunctions::customDecrypt($rsExpenseList->amount, Session::get('normalUserEncryptKey'));
        endforeach;

        $currentMonthsTotalExpense = 0;
        $monthsFirstExpenseData = ExptExpense::select('date', 'amount')->where('user_id', session::get('normalUserId'))->whereMonth('date', date("m"))->get();

        foreach ($monthsFirstExpenseData as $rsMonthsFirstExpenseData) {
            $currentMonthsTotalExpense += CustomFunctions::customDecrypt($rsMonthsFirstExpenseData->amount, Session::get('normalUserEncryptKey'));
        }

        $bankAccountsName = ExptBankAccounts::select('id', 'account_name')->where('user_id', session::get('normalUserId'))->where('active', 1)->get();

        $categoryName = ExptCategory::select('id', 'category_name')->where('user_id', session::get('normalUserId'))->where('active', 1)->get();

        return view('expense', ['expenseList' => $expenseList, 'totalExpense' => $totalExpense, 'currentMonthsTotalExpense' => $currentMonthsTotalExpense, "bankAccountsName" => $bankAccountsName, 'categoryName' => $categoryName]);
    }

    public function expenseProcess(Request $request) {
        if ($request->expense_process_val == "add_expense") {
            return $this->addNewExpense($request);
        } else if ($request->expense_process_val == "get_expense_data") {
            return $this->getExpenseData($request);
        } else if ($request->expense_process_val == "update_expense") {
            return $this->updateExpenseData($request);
        }else if ($request->expense_process_val == "filter_expense") {
            return $this->filterExpenseData($request);
        }
    }

    public function addNewExpense(Request $request) {

        if (!preg_match('/^[0-9]+$/', $request->add_expense_amount_val)) {
            return 'invalid amount';
        }

        $expense_bank_account_id = $request->add_expense_bank_account_val;
        $expense_category = $request->add_expense_category_val;
        $expense_amount = CustomFunctions::customEncrypt($request->add_expense_amount_val, Session::get('normalUserEncryptKey'));
        $expense_desciption = CustomFunctions::customEncrypt($request->add_expense_description_val, Session::get('normalUserEncryptKey'));

        $InsertExpense = new ExptExpense();
        $InsertExpense->user_id = session::get('normalUserId');
        $InsertExpense->account_id = $expense_bank_account_id;
        $InsertExpense->category_id = $expense_category;
        $InsertExpense->amount = $expense_amount;
        $InsertExpense->description = $expense_desciption;
        $InsertExpense->date = date('Y-m-d');
        $InsertExpense->save();

    }
    
    public function getExpenseData(Request $request) {
 
        $expenseId = $request->expense_id_val;

        $expenseData = ExptExpense::select('expt_expense.id', 'expt_bank_accounts.id as account_id', 'expt_category.id as category_id', 'expt_bank_accounts.account_name', 'expt_category.category_name', 'expt_expense.amount', 'expt_expense.description', 'expt_expense.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_expense.account_id')
                                        ->join('expt_category', 'expt_category.id', '=', 'expt_expense.category_id')
                                        ->where('expt_expense.user_id', session::get('normalUserId'))
                                        ->where('expt_category.user_id', session::get('normalUserId'))
                                        ->where('expt_bank_accounts.user_id', session::get('normalUserId'))
                                        ->where('expt_expense.id', $expenseId)
                                        ->orderBy('expt_expense.id', 'DESC')
                                        ->first();

        $bankAccountsName = ExptBankAccounts::select('id', 'account_name')->where('user_id', session::get('normalUserId'))->where('active', 1)->get();

        $categoryName = ExptCategory::select('id', 'category_name')->where('user_id', session::get('normalUserId'))->where('active', 1)->get();

        return view('ajax/ajax_edit_expense', ['expenseData' => $expenseData, 'bankAccountsName' => $bankAccountsName, "categoryName" => $categoryName]);
 
    }

    public function updateExpenseData(Request $request) {

        if (!preg_match('/^[0-9]+$/', $request->update_expense_amount_val)) {
            return 'invalid amount';
        }

        $expense_Id = $request->update_expense_id_val;
        $expense_bank_account_id = $request->update_expense_bankAccount_val;
        $expense_category = $request->update_expense_category_val;
        $expense_amount = CustomFunctions::customEncrypt($request->update_expense_amount_val, Session::get('normalUserEncryptKey'));
        $expense_desciption = CustomFunctions::customEncrypt($request->update_expense_description_val, Session::get('normalUserEncryptKey'));

        ExptExpense::where('id', $expense_Id)->update(array(

            'account_id' => $expense_bank_account_id,
            'category_id' => $expense_category,
            'amount' => $expense_amount,
            'description' => $expense_desciption,

        ));

        return 'Updated';
 
    }
    
    public function filterExpenseData(Request $request) {

        $expenseFilterAccount = $request->filter_expense_account_val;
        $expenseFilterMonth = $request->filter_expense_month_val;
        $expenseFilterYear = $request->filter_expense_year_val;
        $expenseFilterSource = $request->filter_expense_source_val;
        $expenseFilterAmount = $request->filter_expense_amount_val;

        $expenseListQurey = ExptExpense::select('expt_expense.id', 'expt_bank_accounts.account_name', 'expt_category.category_name', 'expt_expense.amount', 'expt_expense.description', 'expt_expense.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_expense.account_id')
                                        ->join('expt_category', 'expt_category.id', '=', 'expt_expense.category_id')
                                        ->where('expt_expense.user_id', session::get('normalUserId'))
                                        ->where('expt_category.user_id', session::get('normalUserId'))
                                        ->where('expt_bank_accounts.user_id', session::get('normalUserId'))
                                        ->orderBy('expt_expense.id', 'DESC');
    
        if ($expenseFilterAccount != '') {
            $expenseListQurey->where('account_id', $expenseFilterAccount);
        }
        if ($expenseFilterMonth != '') {
            $expenseListQurey->whereMonth('date', $expenseFilterMonth);
        }
        if ($expenseFilterYear != '') {
            $expenseListQurey->whereYear('date', $expenseFilterYear);
        }

        $expenseListData = $expenseListQurey->get();

        // // Filter the records based on the partial match
        // $expenseListDataDecrypted = $expenseListData->filter(function ($expenseData) use ($expenseFilterSource, $expenseFilterAmount) {

        //     $decryptedexpenseSource = CustomFunctions::customDecrypt(expenseData->source, Session::get('normalUserEncryptKey'));
        //     $decryptedexpenseAmount = CustomFunctions::customDecrypt(expenseData->amount, Session::get('normalUserEncryptKey'));        //     // Check if each filter is empty or matches the decrypted values
        //     $expenseSourceMatches = empty($expenseFilterSource) || str_contains(strtolower($decryptedexpenseSource), strtolower($expenseFilterSource));
        //     $expenseAmountMatches = empty($expenseFilterAmount) || str_contains(strtolower($decryptedexpenseAmount), strtolower($expenseFilterAmount));

        //     // Return true if all filters match
        //     return $expenseSourceMatches && $expenseAmountMatches;
        // });

        if ($expenseListData->isEmpty()) {
            return '<h2 class="text-center">No Records</h2>';
        }

        return view('ajax/ajax_expense_body', ['expenseList' => $expenseListData]);

    }
}