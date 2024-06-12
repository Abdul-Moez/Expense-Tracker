@isset($incomeData)
    <form action="javascript:void(0);">
        <input type="text" value="{{ $incomeData->income_id }}" class="d-none" id="update_income_id" name="update_income_id">
        <div class="form-floating mb-3">
            <select class="form-select" id="update_income_account" name="update_income_account">
                <option value="">Select Bank Account</option>
                    @foreach ($bankAccountsName as $rsBankAccountsName)
                        <option value="{{ $rsBankAccountsName->id }}" {{ $rsBankAccountsName->id == $incomeData->bank_account_id ? "Selected" : '' }} >{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsName->account_name, Session::get('normalUserEncryptKey')) }}</option>
                    @endforeach
            </select>
            <label class="focus-label">Select Bank Account</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Enter Income Source" id="update_income_source" name="update_income_source" value="{{ \App\ASPLibraries\CustomFunctions::customDecrypt($incomeData->source, Session::get('normalUserEncryptKey')) }}">
            <label class="focus-label">Enter Income Source</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Enter Income Amount" id="update_income_amount" name="update_income_amount" value="{{ \App\ASPLibraries\CustomFunctions::customDecrypt($incomeData->amount, Session::get('normalUserEncryptKey')) }}">
            <label class="focus-label">Enter Income Amount</label>
        </div>
        <div class="form-floating mb-3">
            <textarea id="update_income_description" name="update_income_description" cols="30" rows="5" class="form-control h-auto" placeholder="Enter Income Description">{{ \App\ASPLibraries\CustomFunctions::customDecrypt($incomeData->description, Session::get('normalUserEncryptKey')) }}</textarea>
            <label class="focus-label">Enter Income Description</label>
        </div>
        <div class="w-100 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary submit-btn" id="update_income_btn" name="update_income_btn">Submit</button>
        </div>
    </form>
@endisset