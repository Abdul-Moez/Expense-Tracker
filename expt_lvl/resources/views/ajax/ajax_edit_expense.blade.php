@isset($expenseData)
    <form action="javascript:void(0);">
        <input type="text" value="{{ $expenseData->id }}" class="d-none" id="update_expense_id" name="update_expense_id">
        <div class="form-floating mb-3">
            <select class="form-select" id="update_expense_account" name="update_expense_account">
                <option value="">Select Bank Account</option>
                @foreach ($bankAccountsName as $rsBankAccountsName)
                    <option value="{{ $rsBankAccountsName->id }}" {{ $rsBankAccountsName->id == $expenseData->account_id ? "Selected" : '' }} >{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsName->account_name, Session::get('normalUserEncryptKey')) }}</option>
                @endforeach
            </select>
          <label class="focus-label">Select Bank Account</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" id="update_expense_category" name="update_expense_category">
                <option value="">Select Category</option>
                @foreach ($categoryName as $rsCategoryName)
                    <option value="{{ $rsCategoryName->id }}" {{ $rsCategoryName->id == $expenseData->category_id ? "Selected" : '' }} >{{ $rsCategoryName->category_name }}</option>
                @endforeach
            </select>
          <label class="focus-label">Select Category</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" placeholder="Enter Expense Amount" id="update_expense_amount" name="update_expense_amount" value="{{ \App\ASPLibraries\CustomFunctions::customDecrypt($expenseData->amount, Session::get('normalUserEncryptKey')) }}">
            <label class="focus-label">Enter Expense Amount</label>
        </div>
        <div class="form-floating mb-3">
            <textarea id="update_expense_description" name="update_expense_description" cols="30" rows="5" class="form-control h-auto" placeholder="Enter Expense Description">{{ \App\ASPLibraries\CustomFunctions::customDecrypt($expenseData->description, Session::get('normalUserEncryptKey')) }}</textarea>
            <label class="focus-label">Enter Expense Description</label>
        </div>
        <div class="w-100 d-flex justify-content-center">
            <button type="submit" class="btn btn-primary submit-btn" id="update_expense_btn" name="update_expense_btn">Submit</button>
        </div>
    </form>

@endisset