<?php

namespace App\ASPLibraries;

use App\Models\ExptUsers;
use App\Models\ExptBankAccounts;
use App\Models\ExptCategory;
use App\Models\ExptIncome;
use App\Models\ExptExpense;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CustomFunctions {

    public Static function encrypt($value) {
        return Crypt::encrypt($value);
    }

    public static function decrypt($value) {
        return Crypt::decrypt($value);
    }

    public static function customEncrypt($value, $salt) {
        $method = 'AES-256-CBC';
        $key = hash('sha256', $salt);
        $iv = substr(hash('sha256', 'iv'), 0, 16);

        return openssl_encrypt($value, $method, $key, 0, $iv);
    }

    public static function customDecrypt($value, $salt) {
        $method = 'AES-256-CBC';
        $key = hash('sha256', $salt);
        $iv = substr(hash('sha256', 'iv'), 0, 16);

        return openssl_decrypt($value, $method, $key, 0, $iv);
    }

}