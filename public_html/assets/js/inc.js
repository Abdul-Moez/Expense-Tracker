$( document ).ready(function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    function ShowLoader() {
        $('#big_loader').removeClass('d-none');
    }

    function HideLoader() {
        $('#big_loader').addClass('d-none');
    }

    $(document).on('click', '#add_income_btn', function (e) {
        e.preventDefault();

        var addIncomeBankAccount = $('#add_income_account').val();
        var addIncomeSource = $('#add_income_source').val();
        var addIncomeAmount = $('#add_income_amount').val();
        var addIncomeDescription = $('#add_income_description').val();

        if (addIncomeBankAccount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Account not select',
                text: "Please select a bank account to proceed"
            });
            return false;
        }

        if (addIncomeSource == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Source Empty',
                text: "Please enter income source to proceed"
            });
            return false;
        }

        if (addIncomeAmount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Amount Empty',
                text: "Please enter income amount to proceed"
            });
            return false;
        }

        if (addIncomeAmount != '') {
            if (!(/^[0-9]+$/.test(addIncomeAmount))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Income Amount',
                    text: "Income amount should only contain numbers"
                });
                return false;
            }
        }

        if (addIncomeDescription == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Description Empty',
                text: "Please enter income description to proceed"
            });
            return false;
        }

        data = {
            'add_income_bank_account_val' : addIncomeBankAccount,
            'add_income_source_val' : addIncomeSource,
            'add_income_amount_val' : addIncomeAmount,
            'add_income_description_val' : addIncomeDescription,
            'income_process_val' : 'add_income',
        }

        ShowLoader();

        $.ajax({
            url: '/income_process',
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
                    title: "Income Added successfully",
                    text: "The income has been added",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);

                    $('#add_income_account').val('');
                    $('#add_income_source').val('');
                    $('#add_income_amount').val('');
                    $('#add_income_description').val('');
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

    $(document).on('show.bs.modal','#edit_income',function(event){
        // // Button that triggered the modal
        // var button = $(event.relatedTarget);
        // // Extract info from data-bs-* attributes
        // var recipient = button[0].attributes[3].value;
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const incomeid = button.getAttribute('data-bs-incomeid')

        data = {
            'income_process_val' : 'get_income_data',
            'income_id_val' : incomeid,
        }

        ShowLoader();

        $.ajax({
            url: '/income_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.income_body_edit').html(response);
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

    $(document).on('click', '#update_income_btn', function (e) {
        e.preventDefault();

        var updateIncomeId = $('#update_income_id').val();
        var updateIncomeBankAccount = $('#update_income_account').val();
        var updateIncomeSource = $('#update_income_source').val();
        var updateIncomeAmount = $('#update_income_amount').val();
        var updateIncomeDescription = $('#update_income_description').val();

        if (updateIncomeId == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Try again',
                text: "An error occured please refresh the page and then try again"
            });
            return false;
        }

        if (updateIncomeBankAccount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Account not select',
                text: "Please select a bank account to proceed"
            });
            return false;
        }

        if (updateIncomeSource == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Source Empty',
                text: "Please enter income source to proceed"
            });
            return false;
        }

        if (updateIncomeAmount == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Amount Empty',
                text: "Please enter income amount to proceed"
            });
            return false;
        }

        if (updateIncomeAmount != '') {
            if (!(/^[0-9]+$/.test(updateIncomeAmount))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Income Amount',
                    text: "Income amount should only contain numbers"
                });
                return false;
            }
        }

        if (updateIncomeDescription == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Description Empty',
                text: "Please enter income description to proceed"
            });
            return false;
        }

        data = {
            'income_process_val' : 'update_income',
            'update_income_id_val' : updateIncomeId,
            'update_income_bankAccount_val' : updateIncomeBankAccount,
            'update_income_source_val' : updateIncomeSource,
            'update_income_amount_val' : updateIncomeAmount,
            'update_income_description_val' : updateIncomeDescription,
        }

        ShowLoader();

        $.ajax({
            url: '/income_process',
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
                    title: "Income updated successfully",
                    text: "The income has been updated",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);

                    $('#update_income_id').val('');
                    $('#update_income_account').val('');
                    $('#update_income_source').val('');
                    $('#update_income_amount').val('');
                    $('#update_income_description').val('');
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

    $(document).on('click', '#filter_income_btn', function (e) {
        e.preventDefault();

        var filterIncomeAccount = $('#filter_income_account').val();
        var filterIncomeMonth = $('#filter_income_month').val();
        var filterIncomeYear = $('#filter_income_year').val();
        var filterIncomeSource = $('#filter_income_source').val();
        var filterIncomeAmount = $('#filter_income_amount').val();

        // if (filterIncomeAccount == '' && filterIncomeMonth == '' && filterIncomeYear == '' && filterIncomeSource == '' && filterIncomeAmount == '') {
        if (filterIncomeAccount == '' && filterIncomeMonth == '' && filterIncomeYear == '') {
            Swal.fire({
                icon: 'error',
                title: 'Filter Empty',
                text: "Please select a filter to apply"
            });
            return false;
        }

        data = {
            'income_process_val' : 'filter_income',
            'filter_income_account_val' : filterIncomeAccount,
            'filter_income_month_val' : filterIncomeMonth,
            'filter_income_year_val' : filterIncomeYear,
            'filter_income_source_val' : filterIncomeSource,
            'filter_income_amount_val' : filterIncomeAmount,
        }

        ShowLoader();

        $.ajax({
            url: '/income_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.income_body').html(response);
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