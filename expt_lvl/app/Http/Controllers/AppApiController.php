<?php

namespace App\Http\Controllers;

use App\Models\ExptUsers;
use App\Models\ExptIncome;
use App\Models\ExptExpense;
use App\Models\ExptBankAccounts;
use App\ASPLibraries\CustomFunctions;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
Use DB;
Use Mail;
use Session;


class AppApiController extends BaseController{

    public function loginProcess (Request $request) {
        if ($request->userAppApiProcess_val == "usrLogin") {
            return $this->sendLogin($request);
        }
        else if ($request->userAppApiProcess_val == "usrRegistration") {
            return $this->sendRegister($request);
        }
        else if ($request->userAppApiProcess_val == "dashboardDataGet") {
            return $this->dashboardDataGet($request);
        }
        else if ($request->userAppApiProcess_val == "incomeDataGet") {
            return $this->incomeDataGet($request);
        }
        else if ($request->userAppApiProcess_val == "viewMoreIncome") {
            return $this->viewMoreIncome($request);
        }
        else if ($request->userAppApiProcess_val == "getEditDataIncome") {
            return $this->getEditDataIncome($request);
        }
        else if ($request->userAppApiProcess_val == "setEditDataIncome") {
            return $this->setEditDataIncome($request);
        }
        else if ($request->userAppApiProcess_val == "getBankAccounts") {
            return $this->getBankAccounts($request);
        }
        else if ($request->userAppApiProcess_val == "addIncome") {
            return $this->addIncome($request);
        }
    }

    public function sendRegister (Request $request) {

        $accountCheck = ExptUsers::select('id', 'user_name', 'user_email', 'user_role', 'user_password')
                        ->where('user_email', trim($request->getRegisterUserEmail_val))
                        ->where('active', 1)
                        ->first();

        if ($accountCheck != null) {
            return "email exists";
        } else {

            $InerContact = new ExptUsers();
            $InerContact->user_name = $request->getRegisterUserName_val;
            $InerContact->user_email = trim($request->getRegisterUserEmail_val);
            $InerContact->user_password = md5(trim($request->getRegisterUserPass_val));
            $InerContact->save();

            $accountData = ExptUsers::select('id', 'user_name', 'user_email', 'user_role', 'user_password', 'encryption_key', 'first_login', 'is_pw_updated', 'active')
                                    ->where('user_email', $InerContact->id)
                                    ->first();

            $jsonarray["user_acc_data"] = $accountData;
            $json = json_encode($jsonarray);
            echo $json;
            
            ExptUsers::where('id', $accountData->id)->update(array(
                'first_login' => 0,
            ));

            // return 'ok';

        }        

    }

    public function sendLogin (Request $request) {

        $accountCheck = ExptUsers::select('id', 'user_name', 'user_email', 'user_role', 'user_password', 'encryption_key', 'first_login', 'is_pw_updated', 'active')
                        ->where('user_email', trim($request->userEmail_val))
                        ->first();

        if ($accountCheck->active == 1) {
            if ($accountCheck == null) {
                return "wrong email";
            } else {
                // $storedPassword = Crypt::decrypt($accountCheck->em_password);
                $storedPassword = $accountCheck->user_password;
    
                if ($storedPassword == md5(trim($request->userPass_val))) {

                    $jsonarray["user_acc_data"] = $accountCheck;
                    $json = json_encode($jsonarray);
                    echo $json;
                    
                    ExptUsers::where('id', $accountCheck->id)->update(array(
                        'first_login' => 0,
                    ));
                }
                else {
                    return "wrong password";
                }
            }

        }else {
            return "account deactivated";
        }
    }
    
    public function dashboardDataGet (Request $request) {

        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->userId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->userId_val)->update(['encryption_key' => md5($request->userEncryptionKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->userEncryptionKey_val)) {
                return 'wrong key';
            }
        }

        $monthlyIncome = ExptIncome::select('*')->where('user_id', $request->userId_val);
        $monthlyExpense = ExptExpense::select('*')->where('user_id', $request->userId_val);

        $totalMonthlyIncome = $monthlyIncome->whereMonth('date', date('m'))->get();
        $totalMonthlyExpense = $monthlyExpense->whereMonth('date', date('m'))->get();

        $totalMonthlyIncomeValue = 0;
        $totalMonthlyExpenseValue = 0;

        foreach ($totalMonthlyIncome as $rsTotalMonthlyIncome) {
            $totalMonthlyIncomeValue += CustomFunctions::customDecrypt($rsTotalMonthlyIncome->amount, $request->userEncryptionKey_val);
        }

        foreach ($totalMonthlyExpense as $rsTotalMonthlyExpense) {
            $totalMonthlyExpenseValue += CustomFunctions::customDecrypt($rsTotalMonthlyExpense->amount, $request->userEncryptionKey_val);
        }

        $totalIncome = ExptIncome::select('amount')->where('user_id', $request->userId_val)->get();
        $totalExpense = ExptExpense::select('amount')->where('user_id', $request->userId_val)->get();

        $totalIncomeValue = 0;
        $totalExpenseValue = 0;
        foreach ($totalIncome as $rsTotalIncome) {
            $totalIncomeValue += CustomFunctions::customDecrypt($rsTotalIncome->amount, $request->userEncryptionKey_val);
        }

        foreach ($totalExpense as $rsTotalExpense) {
            $totalExpenseValue += CustomFunctions::customDecrypt($rsTotalExpense->amount, $request->userEncryptionKey_val);
        }

        $recentIncome = ExptIncome::select('*')->where('expt_income.user_id', $request->userId_val)->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_income.account_id')->orderBy('expt_income.id', 'DESC')->get(3);
        $recentExpense = ExptExpense::select('*')->where('expt_expense.user_id', $request->userId_val)->join('expt_bank_accounts','expt_bank_accounts.id', '=', 'expt_expense.account_id')->join('expt_category','expt_category.id', '=', 'expt_expense.category_id')->orderBy('expt_expense.id', 'DESC')->get(3);

        $totalBalance = $totalIncomeValue - $totalExpenseValue;

		$jsonarray["monthly_income_tot"] = $totalIncomeValue;
		$jsonarray["monthly_expense_tot"] = $totalExpenseValue;
		$jsonarray["total_balance"] = $totalBalance;
		$jsonarray["recent_income"] = $recentIncome;
		$jsonarray["recent_expense"] = $recentExpense;

        $json = json_encode($jsonarray);
		echo $json;

    }

    public function incomeDataGet (Request $request) {

        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->userId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->userId_val)->update(['encryption_key' => md5($request->userEncryptionKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->userEncryptionKey_val)) {
                return 'wrong key';
            }
        }
        
        $incomeList = ExptIncome::select('expt_income.id', 'expt_bank_accounts.account_name', 'expt_income.source', 'expt_income.amount', 'expt_income.description', 'expt_income.date')
                                        ->join('expt_bank_accounts', 'expt_bank_accounts.id', '=', 'expt_income.account_id')
                                        ->where('expt_income.user_id', $request->userId_val)
                                        ->where('expt_bank_accounts.user_id', $request->userId_val)
                                        ->orderBy('expt_income.id', 'DESC')
                                        ->get();

        $totalIncome = 0;
                                        
        foreach ($incomeList as $rsIncomeList):
            $totalIncome += CustomFunctions::customDecrypt($rsIncomeList->amount, $request->userEncryptionKey_val);
        endforeach;

        $currentMonthsTotalIncome = 0;
        $monthsFirstIncomeData = ExptIncome::select('date', 'amount')->where('user_id', $request->userId_val)->whereMonth('date', date("m"))->get();

        foreach ($monthsFirstIncomeData as $rsMonthsFirstIncomeData) {
            $currentMonthsTotalIncome += CustomFunctions::customDecrypt($rsMonthsFirstIncomeData->amount, $request->userEncryptionKey_val);
        }

        $incomeListArr = array();
        foreach ($incomeList as $rsIncomeList) {
            $incomeListArr[] = [
                $rsIncomeList->id,
                CustomFunctions::customDecrypt($rsIncomeList->account_name, $request->userEncryptionKey_val),
                CustomFunctions::customDecrypt($rsIncomeList->source, $request->userEncryptionKey_val),
                CustomFunctions::customDecrypt($rsIncomeList->amount, $request->userEncryptionKey_val),
                $rsIncomeList->date
            ];
        }

        if (count($incomeList) > 0) {
            $recentIncome = CustomFunctions::customDecrypt($incomeList[0]->amount, $request->userEncryptionKey_val);;
        }else {
            $recentIncome = 0;
        }

		$jsonarray["incomeList"] = $incomeListArr;
		$jsonarray["recentIncome"] = $recentIncome;
		$jsonarray["totalIncome"] = $totalIncome;
		$jsonarray["currentMonthsTotalIncome"] = $currentMonthsTotalIncome;

        $json = json_encode($jsonarray);
		echo $json;
    }

    public function viewMoreIncome (Request $request) {

        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->userId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->userId_val)->update(['encryption_key' => md5($request->userEncryptionKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->userEncryptionKey_val)) {
                return 'wrong key';
            }
        }

        $getIncomeData = ExptIncome::select('description')->where('id', $request->incomeViewId_val)->where('user_id', $request->userId_val)->first();

        $getIncomeMoreData = CustomFunctions::customDecrypt($getIncomeData->description, $request->userEncryptionKey_val);

		$jsonarray["getIncomeMoreData"] = trim($getIncomeMoreData);

        $json = json_encode($jsonarray);
		echo $json;

    }

    public function getEditDataIncome (Request $request) {

        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->userId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->userId_val)->update(['encryption_key' => md5($request->userEncryptionKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->userEncryptionKey_val)) {
                return 'wrong key';
            }
        }

        $getIncomeData = ExptIncome::select('*')->where('id', $request->incomeViewId_val)->first();

        $getIncomeDataId = $getIncomeData->id;
        $getIncomeDataAccId = $getIncomeData->account_id;
        $getIncomeDataSrc = CustomFunctions::customDecrypt($getIncomeData->source, $request->userEncryptionKey_val);
        $getIncomeDataAmnt = CustomFunctions::customDecrypt($getIncomeData->amount, $request->userEncryptionKey_val);
        $getIncomeDataDescription = CustomFunctions::customDecrypt($getIncomeData->description, $request->userEncryptionKey_val);

        $getBankAccData = ExptBankAccounts::select('*')->where('user_id', $request->userId_val)->get();

        $getBankAccArr = array();
        foreach ($getBankAccData as $rsGetBankAccData) {
            $getBankAccArr[] = [
                $rsGetBankAccData->id,
                $rsGetBankAccData->user_id,
                trim(CustomFunctions::customDecrypt($rsGetBankAccData->account_name, $request->userEncryptionKey_val)),
                trim(CustomFunctions::customDecrypt($rsGetBankAccData->account_type, $request->userEncryptionKey_val)),
                trim(CustomFunctions::customDecrypt($rsGetBankAccData->account_number, $request->userEncryptionKey_val)),
                $rsGetBankAccData->active,
                $rsGetBankAccData->created_at,
            ];
        }

		$jsonarray["getIncomeDataId"] = trim($getIncomeDataId);
		$jsonarray["getIncomeDataAccId"] = trim($getIncomeDataAccId);
		$jsonarray["getIncomeDataSrc"] = trim($getIncomeDataSrc);
		$jsonarray["getIncomeDataAmnt"] = trim($getIncomeDataAmnt);
		$jsonarray["getIncomeDataDescription"] = trim($getIncomeDataDescription);

		$jsonarray["getBankAccArr"] = $getBankAccArr;

        $json = json_encode($jsonarray);
		echo $json;

    }

    public function setEditDataIncome (Request $request) {

        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->userId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->userId_val)->update(['encryption_key' => md5($request->encryptionKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->encryptionKey_val)) {
                return 'wrong key';
            }
        }

        if (!preg_match('/^[0-9]+$/', $request->incomeAmount_val)) {
            return 'invalid amount';
        }
 
        $income_Id = $request->incomeId_val;
        $income_bank_account_id = $request->bankAccId_val;
        $income_source = CustomFunctions::customEncrypt($request->incomeSource_val, $request->encryptionKey_val);
        $income_amount = CustomFunctions::customEncrypt($request->incomeAmount_val, $request->encryptionKey_val);
        $income_desciption = CustomFunctions::customEncrypt($request->description_val, $request->encryptionKey_val);

        ExptIncome::where('id', $income_Id)->update(array(

            'account_id' => $income_bank_account_id,
            'source' => $income_source,
            'amount' => $income_amount,
            'description' => $income_desciption,

        ));

        return 'ok';
    }

    public function getBankAccounts (Request $request) {

        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->usrId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->usrId_val)->update(['encryption_key' => md5($request->encryptKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->encryptKey_val)) {
                return 'wrong key';
            }
        }

        $getBankAccData = ExptBankAccounts::select('*')->where('user_id', $request->usrId_val)->get();

        $getBankAccArr = array();
        foreach ($getBankAccData as $rsGetBankAccData) {
            $getBankAccArr[] = [
                $rsGetBankAccData->id,
                $rsGetBankAccData->user_id,
                trim(CustomFunctions::customDecrypt($rsGetBankAccData->account_name, $request->encryptKey_val)),
                trim(CustomFunctions::customDecrypt($rsGetBankAccData->account_type, $request->encryptKey_val)),
                trim(CustomFunctions::customDecrypt($rsGetBankAccData->account_number, $request->encryptKey_val)),
                $rsGetBankAccData->active,
                $rsGetBankAccData->created_at,
            ];
        }

		$jsonarray["getBankAccArr"] = $getBankAccArr;

        $json = json_encode($jsonarray);
		echo $json;

    }

    public function addIncome (Request $request) {
    
        $chckKeyExists = ExptUsers::select('encryption_key')->where('id', $request->userId_val)->first();

        if ($chckKeyExists->encryption_key == null && $chckKeyExists->encryption_key == '') {
            ExptUsers::where('id', $request->userId_val)->update(['encryption_key' => md5($request->encryptionKey_val)]);
        }else {
            if ($chckKeyExists->encryption_key != md5($request->encryptionKey_val)) {
                return 'wrong key';
            }
        }

        if (!preg_match('/^[0-9]+$/', $request->incomeAmount_val)) {
            return 'invalid amount';
        }

        $income_bank_account_id = $request->bankAccId_val;
        $income_source = CustomFunctions::customEncrypt($request->incomeSource_val, $request->encryptionKey_val);
        $income_amount = CustomFunctions::customEncrypt($request->incomeAmount_val, $request->encryptionKey_val);
        $income_desciption = CustomFunctions::customEncrypt($request->description_val, $request->encryptionKey_val);

        $InsertIncome = new ExptIncome();
        $InsertIncome->user_id = $request->userId_val;
        $InsertIncome->account_id = $income_bank_account_id;
        $InsertIncome->source = $income_source;
        $InsertIncome->amount = $income_amount;
        $InsertIncome->description = $income_desciption;
        $InsertIncome->date = date('Y-m-d');
        $InsertIncome->save();

        return "ok";

    }
}