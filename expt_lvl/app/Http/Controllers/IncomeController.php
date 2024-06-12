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

class IncomeController extends BaseController{

    public function income() {

        if(!session::has('normalUserId')){
            return redirect('/');
        };
        
        $incomeList = ExptIncome::select('expt_income.id', 'expt_bank_accounts.account_name', 'expt_income.source', 'expt_income.amount', 'expt_income.description', 'expt_income.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_income.account_id')
                                        ->where('expt_income.user_id', session::get('normalUserId'))
                                        ->where('expt_bank_accounts.user_id', session::get('normalUserId'))
                                        ->orderBy('expt_income.id', 'DESC')
                                        ->get();

        $totalIncome = 0;
                                        
        foreach ($incomeList as $rsIncomeList):
            $totalIncome += CustomFunctions::customDecrypt($rsIncomeList->amount, Session::get('normalUserEncryptKey'));
        endforeach;

        $currentMonthsTotalIncome = 0;
        $monthsFirstIncomeData = ExptIncome::select('date', 'amount')->where('user_id', session::get('normalUserId'))->whereMonth('date', date("m"))->get();

        foreach ($monthsFirstIncomeData as $rsMonthsFirstIncomeData) {
            $currentMonthsTotalIncome += CustomFunctions::customDecrypt($rsMonthsFirstIncomeData->amount, Session::get('normalUserEncryptKey'));
        }

        $bankAccountsName = ExptBankAccounts::select('id', 'account_name')->where('user_id', session::get('normalUserId'))->where('active', 1)->get();

        return view('income', ['incomeList' => $incomeList, 'totalIncome' => $totalIncome, 'currentMonthsTotalIncome' => $currentMonthsTotalIncome, "bankAccountsName" => $bankAccountsName]);
    }

    public function incomeProcess(Request $request) {
        if ($request->income_process_val == "add_income") {
            return $this->addNewIncome($request);
        } else if ($request->income_process_val == "get_income_data") {
            return $this->getIncomeData($request);
        } else if ($request->income_process_val == "update_income") {
            return $this->updateIncomeData($request);
        }else if ($request->income_process_val == "filter_income") {
            return $this->filterIncomeData($request);
        }
    }

    public function addNewIncome(Request $request) {

        if (!preg_match('/^[0-9]+$/', $request->add_income_amount_val)) {
            return 'invalid amount';
        }

        $income_bank_account_id = $request->add_income_bank_account_val;
        $income_source = CustomFunctions::customEncrypt($request->add_income_source_val, Session::get('normalUserEncryptKey'));
        $income_amount = CustomFunctions::customEncrypt($request->add_income_amount_val, Session::get('normalUserEncryptKey'));
        $income_desciption = CustomFunctions::customEncrypt($request->add_income_description_val, Session::get('normalUserEncryptKey'));

        $InsertIncome = new ExptIncome();
        $InsertIncome->user_id = session::get('normalUserId');
        $InsertIncome->account_id = $income_bank_account_id;
        $InsertIncome->source = $income_source;
        $InsertIncome->amount = $income_amount;
        $InsertIncome->description = $income_desciption;
        $InsertIncome->date = date('Y-m-d');
        $InsertIncome->save();
    }
    
    public function getIncomeData(Request $request) {
 
        $incomeId = $request->income_id_val;

        $incomeData = ExptIncome::select('expt_income.id as income_id', 'expt_bank_accounts.id as bank_account_id', 'expt_bank_accounts.account_name', 'expt_income.source', 'expt_income.amount', 'expt_income.description', 'expt_income.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_income.account_id')
                                        ->where('expt_income.user_id', session::get('normalUserId'))
                                        ->where('expt_income.id', $incomeId)
                                        ->first();

        $bankAccountsName = ExptBankAccounts::select('id', 'account_name')->where('user_id', session::get('normalUserId'))->where('active', 1)->get();

        return view('ajax/ajax_edit_income', ['incomeData' => $incomeData, 'bankAccountsName' => $bankAccountsName]);
 
    }

    public function updateIncomeData(Request $request) {

        if (!preg_match('/^[0-9]+$/', $request->update_income_amount_val)) {
            return 'invalid amount';
        }
 
        $income_Id = $request->update_income_id_val;
        $income_bank_account_id = $request->update_income_bankAccount_val;
        $income_source = CustomFunctions::customEncrypt($request->update_income_source_val, Session::get('normalUserEncryptKey'));
        $income_amount = CustomFunctions::customEncrypt($request->update_income_amount_val, Session::get('normalUserEncryptKey'));
        $income_desciption = CustomFunctions::customEncrypt($request->update_income_description_val, Session::get('normalUserEncryptKey'));

        ExptIncome::where('id', $income_Id)->update(array(

            'account_id' => $income_bank_account_id,
            'source' => $income_source,
            'amount' => $income_amount,
            'description' => $income_desciption,

        ));

        return 'Updated';
 
    }
    
    public function filterIncomeData(Request $request) {

        $incomeFilterAccount = $request->filter_income_account_val;
        $incomeFilterMonth = $request->filter_income_month_val;
        $incomeFilterYear = $request->filter_income_year_val;
        $incomeFilterSource = $request->filter_income_source_val;
        $incomeFilterAmount = $request->filter_income_amount_val;

        $incomeListQurey = ExptIncome::select('expt_income.id as income_id', 'expt_bank_accounts.id as bank_account_id', 'expt_bank_accounts.account_name', 'expt_income.source', 'expt_income.amount', 'expt_income.description', 'expt_income.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_income.account_id')
                                        ->where('expt_income.user_id', session::get('normalUserId'))
                                        ->orderBy('expt_income.id', 'DESC');
    
        if ($incomeFilterAccount != '') {
            $incomeListQurey->where('account_id', $incomeFilterAccount);
        }
        if ($incomeFilterMonth != '') {
            $incomeListQurey->whereMonth('date', $incomeFilterMonth);
        }
        if ($incomeFilterYear != '') {
            $incomeListQurey->whereYear('date', $incomeFilterYear);
        }

        $incomeListData = $incomeListQurey->get();

        // // Filter the records based on the partial match
        // $incomeListDataDecrypted = $incomeListData->filter(function ($incomeData) use ($incomeFilterSource, $incomeFilterAmount) {

        //     $decryptedIncomeSource = Crypt::decrypt($incomeData->source);
        //     $decryptedIncomeAmount = Crypt::decrypt($incomeData->amount);

        //     // Check if each filter is empty or matches the decrypted values
        //     $incomeSourceMatches = empty($incomeFilterSource) || str_contains(strtolower($decryptedIncomeSource), strtolower($incomeFilterSource));
        //     $incomeAmountMatches = empty($incomeFilterAmount) || str_contains(strtolower($decryptedIncomeAmount), strtolower($incomeFilterAmount));

        //     // Return true if all filters match
        //     return $incomeSourceMatches && $incomeAmountMatches;
        // });

        if ($incomeListData->isEmpty()) {
            return '<h2 class="text-center">No Records</h2>';
        }

        return view('ajax/ajax_income_body', ['incomeList' => $incomeListData]);

    }

}