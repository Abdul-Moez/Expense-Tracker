$( document ).ready(function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    function ShowLoader() {
        $('#big_loader').removeClass('d-none');
    }

    function HideLoader() {
        $('#big_loader').addClass('d-none');
    }

    $(document).on('click', '#add_expense_btn', function (e) {
        e.preventDefault();

        var addExpenseBankAccount = $('#add_expense_account').val();
        var addExpenseCategory = $('#add_expense_category').val();
        var addExpenseAmount = $('#add_expense_amount').val();
        var addExpenseDescription = $('#add_expense_description').val();

        if (addExpenseBankAccount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Account not select',
                text: "Please select a bank account to proceed"
            });
            return false;
        }

        if (addExpenseCategory == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Expense Category Empty',
                text: "Please enter Expense category to proceed"
            });
            return false;
        }

        if (addExpenseAmount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Expense Amount Empty',
                text: "Please enter Expense amount to proceed"
            });
            return false;
        }

        if (addExpenseAmount != '') {
            if (!(/^[0-9]+$/.test(addExpenseAmount))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Expense Amount',
                    text: "Expense amount should only contain numbers"
                });
                return false;
            }
        }

        if (addExpenseDescription == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Expense Description Empty',
                text: "Please enter Expense description to proceed"
            });
            return false;
        }

        data = {
            'expense_process_val' : 'add_expense',
            'add_expense_bank_account_val' : addExpenseBankAccount,
            'add_expense_category_val' : addExpenseCategory,
            'add_expense_amount_val' : addExpenseAmount,
            'add_expense_description_val' : addExpenseDescription,
        }

        ShowLoader();

        $.ajax({
            url: '/expense_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {
                HideLoader();

                if (response == 'invalid amount') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Expense Amount',
                        text: "Expense amount should only contain numbers"
                    });
                    return false;
                }

                Swal.fire({
                    icon: 'success',
                    title: "Expense Added successfully",
                    text: "The expense has been added",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);

                    $('#add_expense_account').val('');
                    $('#add_expense_category').val('');
                    $('#add_expense_amount').val('');
                    $('#add_expense_description').val('');
                });

            },
            error: function (result) {

                HideLoader();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
                })
                return false;
            }
        });

    });

    $(document).on('show.bs.modal','#edit_expense',function(event){
        // // Button that triggered the modal
        // var button = $(event.relatedTarget);
        // // Extract info from data-bs-* attributes
        // var recipient = button[0].attributes[3].value;
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const expenseid = button.getAttribute('data-bs-expenseid')

        data = {
            'expense_process_val' : 'get_expense_data',
            'expense_id_val' : expenseid,
        }

        ShowLoader();

        $.ajax({
            url: '/expense_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.expense_body_edit').html(response);
                // $('#editSalaryId').val(salaryId);
                HideLoader();

            },
            error: function (result) {
                Swal.fire({
                    icon: "error",
                    title: "Some Error",
                });
                HideLoader();
                return false;    
            }
        });
    });

    $(document).on('click', '#update_expense_btn', function (e) {
        e.preventDefault();

        var updateExpenseId = $('#update_expense_id').val();
        var updateExpenseBankAccount = $('#update_expense_account').val();
        var updateExpenseCategory = $('#update_expense_category').val();
        var updateExpenseAmount = $('#update_expense_amount').val();
        var updateExpenseDescription = $('#update_expense_description').val();

        if (updateExpenseId == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Try again',
                text: "An error occured please refresh the page and then try again"
            });
            return false;
        }

        if (updateExpenseBankAccount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Account not select',
                text: "Please select a bank account to proceed"
            });
            return false;
        }

        if (updateExpenseCategory == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Expense Source Empty',
                text: "Please enter Expense source to proceed"
            });
            return false;
        }

        if (updateExpenseAmount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Expense Amount Empty',
                text: "Please enter Expense amount to proceed"
            });
            return false;
        }

        if (updateExpenseAmount != '') {
            if (!(/^[0-9]+$/.test(updateExpenseAmount))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Expense Amount',
                    text: "Expense amount should only contain numbers"
                });
                return false;
            }
        }

        if (updateExpenseDescription == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Expense Description Empty',
                text: "Please enter Expense description to proceed"
            });
            return false;
        }

        data = {
            'expense_process_val' : 'update_expense',
            'update_expense_id_val' : updateExpenseId,
            'update_expense_bankAccount_val' : updateExpenseBankAccount,
            'update_expense_category_val' : updateExpenseCategory,
            'update_expense_amount_val' : updateExpenseAmount,
            'update_expense_description_val' : updateExpenseDescription,
        }

        ShowLoader();

        $.ajax({
            url: '/expense_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {
                HideLoader();

                if (response == 'invalid amount') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Income Amount',
                        text: "Income amount should only contain numbers"
                    });
                    return false;
                }

                Swal.fire({
                    icon: 'success',
                    title: "Expense updated successfully",
                    text: "The Expense has been updated",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);

                    $('#update_expense_id').val('');
                    $('#update_expense_account').val('');
                    $('#update_expense_category').val('');
                    $('#update_expense_amount').val('');
                    $('#update_expense_description').val('');
                });

            },
            error: function (result) {

                HideLoader();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
                })
                return false;
            }
        });

    });

    $(document).on('click', '#filter_expense_btn', function (e) {
        e.preventDefault();
 
        var filterExpenseAccount = $('#filter_expense_account').val();
        var filterExpenseMonth = $('#filter_expense_month').val();
        var filterExpenseYear = $('#filter_expense_year').val();
        var filterExpenseSource = $('#filter_expense_source').val();
        var filterExpenseAmount = $('#filter_expense_amount').val();

        // if (filterExpenseAccount == '' && filterExpenseMonth == '' && filterExpenseYear == '' && filterExpenseSource == '' && filterExpenseAmount == '') {
        if (filterExpenseAccount == '' && filterExpenseMonth == '' && filterExpenseYear == '') {
            Swal.fire({
                icon: 'error',
                title: 'Filter Empty',
                text: "Please select a filter to apply"
            });
            return false;
        }

        data = {
            'expense_process_val' : 'filter_expense',
            'filter_expense_account_val' : filterExpenseAccount,
            'filter_expense_month_val' : filterExpenseMonth,
            'filter_expense_year_val' : filterExpenseYear,
            'filter_expense_source_val' : filterExpenseSource,
            'filter_expense_amount_val' : filterExpenseAmount,
        }

        ShowLoader();

        $.ajax({
            url: '/expense_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.expense_body').html(response);
                // $('#editSalaryId').val(salaryId);
                HideLoader();

                $('.datatable').DataTable({
                    searching: false,
                    // order: [[0, 'asc']]
                    // ordering: false
                });

            },
            error: function (result) {

                HideLoader();

                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
                })
                return false;
            }
        });

    });
});