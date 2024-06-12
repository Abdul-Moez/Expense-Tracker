@if (isset($bankAccountData))
<form action="javascript:void(0)">
    <input type="text" value="{{ $bankAccountData->id }}" class="d-none" id="update_bank_account_id">
    <div class="form-floating mb-3">
        <input class="form-control" type="text" id="update_bank_account_name" name="update_bank_account_name" value="{{ \App\ASPLibraries\CustomFunctions::customDecrypt($bankAccountData->account_name, Session::get('normalUserEncryptKey')) }}" required>
        <label>Account Name <span class="text-danger">*</span></label>
    </div>
    <div class="form-floating mb-3">
        <?php $accountType = \App\ASPLibraries\CustomFunctions::customDecrypt($bankAccountData->account_type, Session::get('normalUserEncryptKey')) ?>
        <select class="form-select" id="update_bank_account_type" name="update_bank_account_type" required>
            <option {{ $accountType == "Personal" ? 'selected' : '' }} value="Personal">Personal</option>
            <option {{ $accountType == "Savings" ? 'selected' : '' }} value="Savings">Savings</option>
            <option {{ $accountType == "Business" ? 'selected' : '' }} value="Business">Business</option>
            <option {{ $accountType == "Cash Wallet" ? 'selected' : '' }} value="Cash Wallet">Cash Wallet</option>
        </select>
        <label class="focus-label">Select Account Type <span class="text-danger">*</span></label>
    </div>
    <div class="form-floating mb-3">
        <input class="form-control" type="text" id="update_bank_account_number" name="update_bank_account_number" value="{{ \App\ASPLibraries\CustomFunctions::customDecrypt($bankAccountData->account_number, Session::get('normalUserEncryptKey')) }}" required>
        <label>Account Number <span class="text-danger">*</span></label>
    </div>
    <div class="form-floating mb-3">
        <select class="form-select" id="update_bank_account_active" name="update_bank_account_active" required>
            <option {{ $bankAccountData->active == 1 ? 'Selected' : '' }} value="1">Yes</option>
            <option {{ $bankAccountData->active == 0 ? 'Selected' : '' }} value="0">No</option>
        </select>
        <label class="focus-label">Select Account Type <span class="text-danger">*</span></label>
    </div>
    <div class="w-100 d-flex justify-content-center">
        <button class="btn btn-primary submit-btn" id="update_bank_account_btn">Update Account</button>
    </div>
</form>
@endif