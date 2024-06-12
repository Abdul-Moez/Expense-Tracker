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


class BankAccountsController extends BaseController{

    public function bankAccounts() {

        // dd(Crypt::encrypt('Test'));

        if(!session::has('normalUserId')){
            return redirect('/');
        };

        $bankAccountsList = ExptBankAccounts::select('id', 'account_name', 'account_type', 'account_number', 'active', 'created_at')
                                            ->where('user_id', session::get('normalUserId'))
                                            ->orderBy('active', 'DESC')
                                            ->orderBy('id', 'DESC')
                                            ->get();

        $bankAccounts = ExptBankAccounts::select('expt_bank_accounts.id', 'expt_income.amount')
                                        ->where('expt_income.user_id', session::get('normalUserId'))
                                        ->join('expt_income', 'expt_income.account_id', '=', 'expt_bank_accounts.id')
                                        ->get();
        
        $accountBalancesDesc = [];
        
        foreach ($bankAccounts as $account) {
            $decryptedAmount = CustomFunctions::customDecrypt($account->amount, Session::get('normalUserEncryptKey'));
            if (isset($accountBalancesDesc[$account->id])) {
                $accountBalancesDesc[$account->id] += $decryptedAmount;
            } else {
                $accountBalancesDesc[$account->id] = $decryptedAmount;
            }
        }
        
        arsort($accountBalancesDesc); // Sort the account balances in descending order
        
        if (!empty($accountBalancesDesc)) {
            $highestBalanceAccountId = key($accountBalancesDesc);
            $highestBalance = current($accountBalancesDesc);
            
            // dd("Account ID with Highest Balance: $highestBalanceAccountId, Highest Balance: $highestBalance");
            $bankAccountDataDesc = ExptBankAccounts::select('account_name')
                                                ->where('id', $highestBalanceAccountId)
                                                ->first();

            $bankAccountNameDesc = CustomFunctions::customDecrypt($bankAccountDataDesc->account_name, Session::get('normalUserEncryptKey'));

        } else {
            // dd("No bank accounts found for the user.");
            $bankAccountNameDesc = '';
        }
        
        
        $accountBalancesAsc = [];
        
        foreach ($bankAccounts as $account) {
            $decryptedAmount = CustomFunctions::customDecrypt($account->amount, Session::get('normalUserEncryptKey'));
            if (isset($accountBalancesAsc[$account->id])) {
                $accountBalancesAsc[$account->id] += $decryptedAmount;
            } else {
                $accountBalancesAsc[$account->id] = $decryptedAmount;
            }
        }
        
        asort($accountBalancesAsc); // Sort the account balances in descending order
        
        if (!empty($accountBalancesAsc)) {
            $lowestBalanceAccountId = key($accountBalancesAsc);
            $lowestBalance = current($accountBalancesAsc);
            
            // dd("Account ID with Highest Balance: $lowestBalanceAccountId, Highest Balance: $lowestBalance");
            $bankAccountDataAsc = ExptBankAccounts::select('account_name')
                                                ->where('id', $lowestBalanceAccountId)
                                                ->first();

            $bankAccountNameAsc = CustomFunctions::customDecrypt($bankAccountDataAsc->account_name, Session::get('normalUserEncryptKey'));

        } else {
            // dd("No bank accounts found for the user.");
            $bankAccountNameAsc = '';
        }

        return view('bank_accounts', ['bankAccountsList' => $bankAccountsList, 'bankAccountNameDesc' => $bankAccountNameDesc, 'bankAccountNameAsc' => $bankAccountNameAsc]);
    }

    public function bankAccountsProcess(Request $request) {
        if ($request->bank_account_process_val == "add_bank_account") {
            return $this->addNewBankAccount($request);
        } else if ($request->bank_account_process_val == "get_bank_account_data") {
            return $this->getBankAccountData($request);
        } else if ($request->bank_account_process_val == "update_bank_account") {
            return $this->updateBankAccountData($request);
        }else if ($request->bank_account_process_val == "filter_bank_account") {
            return $this->filterBankAccountData($request);
        }
    }

    public function addNewBankAccount(Request $request) {

        if (!preg_match('/^[0-9]+$/', $request->add_bank_bccount_number_val)) {
            return 'invalid account number';
        }

        $bank_account_name = CustomFunctions::customEncrypt($request->add_bank_bccount_name_val, Session::get('normalUserEncryptKey'));
        $bank_account_type = CustomFunctions::customEncrypt($request->add_bank_bccount_type_val, Session::get('normalUserEncryptKey'));
        $bank_account_number = CustomFunctions::customEncrypt($request->add_bank_bccount_number_val, Session::get('normalUserEncryptKey'));

        $CheckBankAccountExists = ExptBankAccounts::select('id', 'account_name', 'account_number')->where('user_id', session::get('normalUserId'))->get();

        foreach ($CheckBankAccountExists as $rsCheckBankAccountExists) {

            if (CustomFunctions::customDecrypt($rsCheckBankAccountExists->account_name, Session::get('normalUserEncryptKey')) == $request->add_bank_bccount_name_val) {
                return "account name exists";
            }

            if (CustomFunctions::customDecrypt($rsCheckBankAccountExists->account_number, Session::get('normalUserEncryptKey')) == $request->add_bank_bccount_number_val) {
                return "account number exists";
            }
        }

        $InsertBankAccount = new ExptBankAccounts();
        $InsertBankAccount->user_id = session::get('normalUserId');
        $InsertBankAccount->account_name = $bank_account_name;
        $InsertBankAccount->account_type = $bank_account_type;
        $InsertBankAccount->account_number = $bank_account_number;
        $InsertBankAccount->save();

    }
    
    public function getBankAccountData(Request $request) {
 
        $bankAccountId = $request->bank_account_id_val;

        $bankAccountData = ExptBankAccounts::select('id', 'account_name', 'account_type', 'account_number', 'active', 'created_at')
                                            ->where('user_id', session::get('normalUserId'))
                                            ->where('id', $bankAccountId)
                                            ->first();

        return view('ajax/ajax_edit_bank_account', ['bankAccountData' => $bankAccountData]);
 
    }

    public function updateBankAccountData(Request $request) {

        if (!preg_match('/^[0-9]+$/', $request->update_account_number_val)) {
            return 'invalid account number';
        }
 
        $bankAccountsId = $request->update_account_id_val;
        $bankAccountsName = CustomFunctions::customEncrypt($request->update_account_name_val, Session::get('normalUserEncryptKey'));
        $bankAccountsType = CustomFunctions::customEncrypt($request->update_account_type_val, Session::get('normalUserEncryptKey'));
        $bankAccountsNumber = CustomFunctions::customEncrypt($request->update_account_number_val, Session::get('normalUserEncryptKey'));
        $bankAccountsActive = $request->update_account_active_val;

        $CheckBankAccountExists = ExptBankAccounts::select('id', 'account_name', 'account_number')->where('user_id', session::get('normalUserId'))->where('id', '<>', $bankAccountsId)->get();

        foreach ($CheckBankAccountExists as $rsCheckBankAccountExists) {

            if (CustomFunctions::customDecrypt($rsCheckBankAccountExists->account_name, Session::get('normalUserEncryptKey')) == $request->update_account_name_val) {
                return "account name exists";
            }

            if (CustomFunctions::customDecrypt($rsCheckBankAccountExists->account_number, Session::get('normalUserEncryptKey')) == $request->update_account_number_val) {
                return "account number exists";
            }
        }

        ExptBankAccounts::where('id', $bankAccountsId)->update(array(
            'account_name' => $bankAccountsName,
            'account_type' => $bankAccountsType,
            'account_number' => $bankAccountsNumber,
            'active' => $bankAccountsActive,
        ));

        return 'Updated';
    }
    
    public function filterBankAccountData(Request $request) {

        $accountFilterName = $request->filter_bank_account_name_val;
        $accountFilterNumber = $request->filter_bank_account_number_val;
        $accountFilterType = $request->filter_bank_account_type_val;
        $accountFilterActive = $request->filter_bank_account_active_val;

        $bankAccountsListQuery = ExptBankAccounts::select('id', 'account_name', 'account_type', 'account_number', 'active', 'created_at')
                                                ->where('user_id', session::get('normalUserId'))
                                                ->orderBy('id', 'DESC');

        $bankAccountsList = $bankAccountsListQuery->get();

        // Filter the records based on the partial match
        $filteredBankAccounts = $bankAccountsList->filter(function ($bankAccount) use ($accountFilterName, $accountFilterNumber, $accountFilterType, $accountFilterActive) {
            // Decrypt the account_name, account_number, and account_type
            $decryptedAccountName = CustomFunctions::customDecrypt($bankAccount->account_name, Session::get('normalUserEncryptKey'));
            $decryptedAccountNumber = CustomFunctions::customDecrypt($bankAccount->account_number, Session::get('normalUserEncryptKey'));
            $decryptedAccountType = CustomFunctions::customDecrypt($bankAccount->account_type, Session::get('normalUserEncryptKey'));

            // Check if each filter is empty or matches the decrypted values
            $nameMatches = empty($accountFilterName) || str_contains(strtolower($decryptedAccountName), strtolower($accountFilterName));
            $numberMatches = empty($accountFilterNumber) || str_contains(strtolower($decryptedAccountNumber), strtolower($accountFilterNumber));
            $typeMatches = empty($accountFilterType) || str_contains(strtolower($decryptedAccountType), strtolower($accountFilterType));
            $activeMatches = empty($accountFilterActive) || $bankAccount->active == $accountFilterActive;

            // Return true if all filters match
            return $nameMatches && $numberMatches && $typeMatches && $activeMatches;
        });

        if ($filteredBankAccounts->isEmpty()) {
            return '<h2 class="text-center">No Records</h2>';
        }

        return view('ajax/ajax_bank_account_body', ['bankAccountsList' => $filteredBankAccounts]);


    }

}