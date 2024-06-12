<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account Name</th>
                    <th>Account Type</th>
                    <th>Account Number</th>
                    <th>Active</th>
                    <th>Created At</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $bankAccountsId = 1; ?>
                @foreach ($bankAccountsList as $rsBankAccountsList)
                    <tr>
                        <td>{{ $bankAccountsId }}</td>
                        <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsList->account_name, Session::get('normalUserEncryptKey')) }}</td>
                        <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsList->account_type, Session::get('normalUserEncryptKey')) }}</td>
                        <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsBankAccountsList->account_number, Session::get('normalUserEncryptKey')) }}</td>
                        <td>{{ $rsBankAccountsList->active == 1 ? 'Yes' : 'No' }}</td>
                        <td>{{ date('Y-M-d (l)', strtotime($rsBankAccountsList->created_at)) }}</td>
                        <td class="text-end">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_bank_account" data-bs-bankaccountid="{{ $rsBankAccountsList->id }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $bankAccountsId++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>