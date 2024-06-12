$( document ).ready(function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    function ShowLoader() {
        $('#big_loader').removeClass('d-none');
    }

    function HideLoader() {
        $('#big_loader').addClass('d-none');
    }
    
    $(document).on('click', '#add_bank_account_btn', function (e) {
        e.preventDefault();

        var addBankAccountName = $('#add_bank_account_name').val();
        var addBankAccountType = $('#add_bank_account_type').val();
        var addBankAccountNumber = $('#add_bank_account_number').val();

        if (addBankAccountName == '') {
            Swal.fire({
                icon: 'error',
                title: 'Account Name Empty',
                text: "Account Name can't be empty"
            });
            return false;
        }

        if (addBankAccountType == '') {
            Swal.fire({
                icon: 'error',
                title: 'Account Type Empty',
                text: "Account Type can't be empty"
            });
            return false;
        }

        if (addBankAccountNumber == '') {
            Swal.fire({
                icon: 'error',
                title: 'Account Number Empty',
                text: "Account Number can't be empty"
            });
            return false;
        }

        if (addBankAccountNumber != '') {
            if (!(/^[0-9]+$/.test(addBankAccountNumber))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Bank Acoount Number',
                    text: "Bank Acoount number should only contain numbers"
                });
                return false;
            }
        }

        data = {
            'bank_account_process_val' : 'add_bank_account',
            'add_bank_bccount_name_val' : addBankAccountName,
            'add_bank_bccount_type_val' : addBankAccountType,
            'add_bank_bccount_number_val' : addBankAccountNumber,
        }

        ShowLoader();

        $.ajax({
            url: '/bank_accounts_process',
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

                if (response == 'invalid account number') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Bank Acoount Number',
                        text: "Bank Acoount number should only contain numbers"
                    });
                    return false;
                }
                
                if (response == 'account name exists') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Account Name Exists',
                        text: "The Account Name you entered already exists"
                    })
                    return false;
                }

                if (response == 'account number exists') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Account Number Exists',
                        text: "The Account Number you entered already exists"
                    })
                    return false;
                }

                Swal.fire({
                    icon: 'success',
                    title: "Bank Account Added",
                    text: "The bank account has been added successfully",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);
                    $('#add_bank_account').modal('hide');
    
                    $('#add_bank_account_name').val('');
                    $('#add_bank_account_type').val('');
                    $('#add_bank_account_number').val('');
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

    $(document).on('show.bs.modal','#edit_bank_account',function(event){
        // // Button that triggered the modal
        // var button = $(event.relatedTarget);
        // // Extract info from data-bs-* attributes
        // var recipient = button[0].attributes[3].value;
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const bankAccountId = button.getAttribute('data-bs-bankaccountid')

        data = {
            'bank_account_process_val' : 'get_bank_account_data',
            'bank_account_id_val' : bankAccountId,
        }

        ShowLoader();

        $.ajax({
            url: '/bank_accounts_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.edit_bank_account_body').html(response);
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

    $(document).on('click', '#update_bank_account_btn', function (e) {
        e.preventDefault();

        var updateBankAccountId = $('#update_bank_account_id').val();
        var updateBankAccountName = $('#update_bank_account_name').val();
        var updateBankAccountType = $('#update_bank_account_type').val();
        var updateBankAccountNumber = $('#update_bank_account_number').val();
        var updateBankAccountActive = $('#update_bank_account_active').val();

        if (updateBankAccountName == '') {
            Swal.fire({
                icon: 'error',
                title: 'Account Name Empty',
                text: "Account name can't be empty"
            });
            return false;
        }
        if (updateBankAccountType == '') {
            Swal.fire({
                icon: 'error',
                title: 'Account Type Empty',
                text: "Account type can't be empty"
            });
            return false;
        }
        if (updateBankAccountNumber == '') {
            Swal.fire({
                icon: 'error',
                title: 'Account Number Empty',
                text: "Account number can't be empty"
            });
            return false;
        }

        if (updateBankAccountNumber != '') {
            if (!(/^[0-9]+$/.test(updateBankAccountNumber))) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Bank Acoount Number',
                    text: "Bank Acoount number should only contain numbers"
                });
                return false;
            }
        }

        if (updateBankAccountId == '') {
            Swal.fire({
                icon: 'error',
                title: 'Refresh the page',
                text: "Please refresh the page and then try again."
            });
            return false;
        }

        data = {
            'bank_account_process_val' : 'update_bank_account',
            'update_account_id_val' : updateBankAccountId,
            'update_account_name_val' : updateBankAccountName,
            'update_account_type_val' : updateBankAccountType,
            'update_account_number_val' : updateBankAccountNumber,
            'update_account_active_val' : updateBankAccountActive,
        }

        ShowLoader();

        $.ajax({
            url: '/bank_accounts_process',
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

                if (response == 'invalid account number') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Bank Acoount Number',
                        text: "Bank Acoount number should only contain numbers"
                    });
                    return false;
                }
                
                if (response == 'account name exists') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Account Name Exists',
                        text: "The Account Name you entered already exists"
                    })
                    return false;
                }

                if (response == 'account number exists') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Account Number Exists',
                        text: "The Account Number you entered already exists"
                    })
                    return false;
                }
                
                Swal.fire({
                    icon: 'success',
                    title: "Account Updated",
                    text: "The Account has been updated successfully",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);
                    $('#edit_bank_account').modal('hide');
    
                    $('#update_bank_account_id').val('');
                    $('#update_bank_account_name').val('');
                    $('#update_bank_account_type').val('');
                    $('#update_bank_account_number').val('');
                    $('#update_bank_account_active').val('');
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

    $(document).on('click', '#filter_account_btn', function (e) {
        e.preventDefault();

        var filterBankAccountName = $('#filter_account_name').val();
        var filterBankAccountNumber = $('#filter_account_number').val();
        var filterBankAccountType = $('#filter_account_type').val();
        var filterBankAccountActive = $('#filter_account_active').val();

        if (filterBankAccountName == '' && filterBankAccountNumber == '' && filterBankAccountType == "" && filterBankAccountActive == "") {
            Swal.fire({
                icon: 'error',
                title: 'Filter Empty',
                text: "Please select a filter to apply"
            });
            return false;
        }

        data = {
            'bank_account_process_val' : 'filter_bank_account',
            'filter_bank_account_name_val' : filterBankAccountName,
            'filter_bank_account_number_val' : filterBankAccountNumber,
            'filter_bank_account_type_val' : filterBankAccountType,
            'filter_bank_account_active_val' : filterBankAccountActive,
        }

        ShowLoader();

        $.ajax({
            url: '/bank_accounts_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.bank_accounts_body').html(response);
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