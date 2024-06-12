<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-striped custom-table mb-0 datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Account Name</th>
                    <th>Income Source</th>
                    <th>Income Amount</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $incomeId = 1; ?>
                @foreach ($incomeList as $rsIncomeList)
                    <tr>
                        <td>{{ $incomeId }}</td>
                        <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsIncomeList->account_name, Session::get('normalUserEncryptKey')) }}</td>
                        <td>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsIncomeList->source, Session::get('normalUserEncryptKey')) }}</td>
                        <td><span>Rs </span>{{ number_format(\App\ASPLibraries\CustomFunctions::customDecrypt($rsIncomeList->amount, Session::get('normalUserEncryptKey')), 2, ".", ",") }}</td>
                        <td><textarea cols="20" rows="1" readonly disabled>{{ \App\ASPLibraries\CustomFunctions::customDecrypt($rsIncomeList->description, Session::get('normalUserEncryptKey')) }}</textarea></td>
                        <td>{{ date('Y-M-d (l)', strtotime($rsIncomeList->date)) }}</td>
                        <td class="text-end">
                            <div class="dropdown dropdown-action">
                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#edit_income" data-bs-incomeid="{{ $rsIncomeList->id }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php $incomeId++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
</div>