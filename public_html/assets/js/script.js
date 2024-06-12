$( document ).ready(function () {

    function ShowLoader() {
        $('#big_loader').removeClass('d-none');
    }

    function HideLoader() {
        $('#big_loader').addClass('d-none');
    }

    // Email Validation
    function IsEmail(email) {
        var regex =
        /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }    

    $(document).on('click', '#toggle-password', function () {
        $('#toggle-password').toggleClass('fa-eye-slash fa-eye');
        $('#user-password').attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password';
        });
    });
    $(document).on('click', '#toggle-password-register', function () {
        $('#toggle-password-register').toggleClass('fa-eye-slash fa-eye');
        $('#user-register-pass').attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password';
        });
    });
    $(document).on('click', '#toggle-rep-password-register', function () {
        $('#toggle-rep-password-register').toggleClass('fa-eye-slash fa-eye');
        $('#user-register-repass').attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password';
        });
    });

    $(document).on('click', '#user-login-btn', function (e) {
        e.preventDefault();

        var getUserEmail = $('#user-email').val();
        var getUserPass = $('#user-password').val();

        if (getUserEmail == '') {
            Swal.fire({
                icon: 'error',
                title: "Email can't be empty",
            })
            return false;
        }
        if (getUserPass == '') {
            Swal.fire({
                icon: 'error',
                title: "Password can't be empty",
            })
            return false;
        }

        if (IsEmail(getUserEmail) == false) {
            Swal.fire({
                icon: 'error',
                title: 'InValid Email',
                text: 'Please enter valid email',
            })
            return false;
        }

        $('#user-login-btn').addClass('d-none');
        $('#login-loader').removeClass('d-none');

        data = {
            'userEmail_val' : getUserEmail,
            'userPass_val' : getUserPass,
            'login_process_val' : 'login',
        }

        $.ajax({
            url: '/login_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                if(response == "Wrong email") {
                    $('#user-login-btn').removeClass('d-none');
                    $('#login-loader').addClass('d-none');
                    Swal.fire({
                        title: 'Wrong Email!',
                        text: "The Email you provided doesn't exist, please enter correct Email and then try again.",
                        icon: 'error',
                    })
                    return false;
                }

                if(response == "Wrong password") {
                    $('#user-login-btn').removeClass('d-none');
                    $('#login-loader').addClass('d-none');
                    Swal.fire({
                        title: 'Wrong Password!',
                        text: "The Credentials you provided doesn't match any account, please enter correct credentials and then try again.",
                        icon: 'error',
                    })
                    return false;
                }

                $('#user-login-btn').addClass('d-none');
                $('#login-loader').addClass('d-none');
                $('#login-success').removeClass('d-none');

                window.location.assign('/dashboard');

            },
            error: function (result) {
                $('#user-login-btn').removeClass('d-none');
                $('#login-loader').addClass('d-none');

                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
                return false;
            }
        });

    });
    
    $(document).on('click', '#user-register-btn', function (e) {
        e.preventDefault();

        var getRegisterUserName = $('#user-register-name').val();
        var getRegisterUserEmail = $('#user-register-email').val();
        var getRegisterUserPass = $('#user-register-pass').val();
        var getRegisterUserRePass = $('#user-register-repass').val();

        if (getRegisterUserName == '') {
            Swal.fire({
                icon: 'error',
                title: "Name can't be empty",
            })
            return false;
        }
        if (getRegisterUserEmail == '') {
            Swal.fire({
                icon: 'error',
                title: "Email can't be empty",
            })
            return false;
        }
        if (getRegisterUserPass == '') {
            Swal.fire({
                icon: 'error',
                title: "Pass can't be empty",
            })
            return false;
        }
        if (getRegisterUserRePass == '') {
            Swal.fire({
                icon: 'error',
                title: "Repeat Pass can't be empty",
            })
            return false;
        }

        if (getRegisterUserPass != getRegisterUserRePass) {
            Swal.fire({
                icon: 'error',
                title: 'Not Same Password',
                text: 'Password and repeat password is not same',
            })
            return false;
        }

        if (IsEmail(getRegisterUserEmail) == false) {
            Swal.fire({
                icon: 'error',
                title: 'InValid Email',
                text: 'Please enter valid email',
            })
            return false;
        }

        $('#user-register-btn').addClass('d-none');
        $('#register-loader').removeClass('d-none');

        data = {
            'getRegisterUserName_val' : getRegisterUserName,
            'getRegisterUserEmail_val' : getRegisterUserEmail,
            'getRegisterUserPass_val' : getRegisterUserPass,
            'getRegisterUserRePass_val' : getRegisterUserRePass,
            'login_process_val' : 'register',
        }

        $.ajax({
            url: '/login_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                if(response == "email exists") {
                    $('#user-register-btn').removeClass('d-none');
                    $('#register-loader').addClass('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Exists!',
                        text: "The Email you provided already exist, please enter correct another and or login.",
                    })
                    return false;
                }

                $('#user-register-btn').addClass('d-none');
                $('#register-loader').addClass('d-none');
                $('#register-success').removeClass('d-none');

                window.location.assign('/dashboard');

            },
            error: function (result) {
                $('#user-register-btn').removeClass('d-none');
                $('#register-loader').addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
                return false;
            }
        });

    });

    $(document).on('click', '#forogtPassBtn', function (e) {
        e.preventDefault();

        var getUserEmail = $('#forgotPasswordEmail').val();

        if (getUserEmail == '') {
            Swal.fire({
                icon: 'error',
                title: "Email can't be empty",
            })
            return false;
        }

        if (IsEmail(getUserEmail) == false) {
            Swal.fire({
                icon: 'error',
                title: 'InValid Email',
                text: 'Please enter valid email',
            })
            return false;
        }

        $('#forogtPassBtn').addClass('d-none');
        $('#forgotPass-loader').removeClass('d-none');

        data = {
            'userEmail_val' : getUserEmail,
            'login_process_val': "forgot_pass",
        }

        $.ajax({
            url: '/login_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                if(response == "Wrong email") {
                    $('#forogtPassBtn').removeClass('d-none');
                    $('#forgotPass-loader').addClass('d-none');
                    Swal.fire({
                        title: 'Wrong Email!',
                        text: "The Email you provided doesn't exist, please enter correct Email and then try again.",
                        icon: 'error',
                    })
                    return false;
                }

                $('#forogtPassBtn').addClass('d-none');
                $('#forgotPass-loader').addClass('d-none');
                $('#forgotPass-success').removeClass('d-none');

                window.location.assign('/dashboard');

            },
            error: function (result) {
                $('#forogtPassBtn').removeClass('d-none');
                $('#forgotPass-loader').addClass('d-none');

                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
                return false;
            }
        });

    });

    $(document).on('click','#resetPassBtn',function(e){
        e.preventDefault();

        var resetNewPass = $('#resetNewPassword').val();
        var resetConfirmNewPass = $('#resetConfirmNewPassword').val();
        var resetUrlEmail = $('#url_email').val();

        if (resetNewPass == '') {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "New password can't be empty",
            });
            return false;
        }
        if (resetConfirmNewPass == '') {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Confirm new password can't be empty",
            });
            return false;
        }
        if (resetNewPass !== resetConfirmNewPass) {
            Swal.fire({
                icon: "error",
                title: "Not Same",
                text: "The new password and confirm new password should be same",
            });
            return false;            
        }
        if (resetUrlEmail == '') {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Please refresh the page and then try again",
            });
            return false;
        }

        var data = {
            'login_process_val': "reset_pass",
            'newPass_val': resetNewPass,
            'confirmNewPass_val': resetConfirmNewPass,
            'urlEmail_val': resetUrlEmail
        };

        $('#resetPass-loader').removeClass('d-none');
        $('#resetPassBtn').addClass('d-none');

        $.ajax({
            url: '/login_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                if (response == "email doesn't exsist") {
                    Swal.fire({
                        icon: "error",
                        title: "Email Doesn't Exists",
                        text: "The Email you provide doesn't exists in our database, Please enter correct email and then try again",
                    });
                    $('#resetPass-loader').addClass('d-none');
                    $('#resetPassBtn').removeClass('d-none');
                    return false;
                }

                Swal.fire({
                    icon: "success",
                    title: "Password Updated",
                });

                $('#resetPass-loader').addClass('d-none');
                $('#resetPassBtn').removeAttr('id');
                
                $('#resetPass-success').removeClass('d-none');

                $('#resetPasswordEmail').val('');

                $('#resetNewPassword').attr('disabled', 'true');
                $('#resetConfirmNewPassword').attr('disabled', 'true');
                
                $('#resetNewPassword').val('');
                $('#resetConfirmNewPassword').val('');
                
                $('#resetNewPassword').removeAttr('id');
                $('#resetConfirmNewPassword').removeAttr('id');
                                
                // window.location.assign(baseUrl + '/');

                // window.location.assign('/ep_login');

            },
            error: function (result) {
                Swal.fire({
                    icon: "error",
                    title: "Some Error",
                });
                $('#resetPass-loader').addClass('d-none');
                $('#resetPassBtn').removeClass('d-none');
                return false;                
            }
        });
    });

    $(document).on('click', '.logout-btn', function (e) {
        e.preventDefault();

        ShowLoader();

        data = {
            'login_process_val' : 'logout',
        }

        $.ajax({
            url: '/login_process',
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

                if (response == "logout successfull") {
                    
                    Swal.fire({
                        icon: 'info',
                        title: 'Loged Out!',
                        text: 'You have been looged out successfully',
                        timerProgressBar: 'true',
                        timer: '1000',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    })

                    function redirect() {
                        // window.location.assign(baseUrl + "/");
                        window.location.assign("/");
                    }
                    setTimeout(redirect, 900);
                }

            },
            error: function (result) {

                HideLoader();

                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
                return false;
            }
        });

    });

    $(document).on('click', '#category-add', function (e) {
        e.preventDefault();

        var categoryName = $('#category-name').val();

        if (categoryName == '') {
            Swal.fire({
                icon: 'error',
                title: 'Category Empty',
                text: "Category name can't be empty"
            });
            return false;
        }

        data = {
            'category_process_val' : 'add_category',
            'category_name_val' : categoryName,
        }

        ShowLoader();

        $.ajax({
            url: '/category_process',
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
                
                if (response == 'category exists') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Category Exists',
                        text: "The Category you entered already exists"
                    })
                    return false;
                    
                }

                Swal.fire({
                    icon: 'success',
                    title: "Category added successfully",
                    text: "The category has been added",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);
                    $('#add_category').modal('hide');
    
                    $('#category-name').val('');
                });

            },
            error: function (result) {

                HideLoader();

                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
                return false;
            }
        });

    });

    $(document).on('show.bs.modal','#edit_category',function(event){
        // // Button that triggered the modal
        // var button = $(event.relatedTarget);
        // // Extract info from data-bs-* attributes
        // var recipient = button[0].attributes[3].value;
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const catId = button.getAttribute('data-bs-catid')

        data = {
            'category_process_val' : 'get_category_data',
            'category_id_val' : catId,
        }

        ShowLoader();

        $.ajax({
            url: '/category_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.edit_category_body').html(response);
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

    $(document).on('click', '#update_category_btn', function (e) {
        e.preventDefault();

        var updateCategoryId = $('#update_category_id').val();
        var updateCategoryName = $('#update_category_name').val();
        var updateCategoryActive = $('#update_category_active').val();

        if (updateCategoryName == '') {
            Swal.fire({
                icon: 'error',
                title: 'Category Empty',
                text: "Category name can't be empty"
            });
            return false;
        }

        if (updateCategoryId == '') {
            Swal.fire({
                icon: 'error',
                title: 'Refresh the page',
                text: "Please refresh the page and then try again."
            });
            return false;
        }

        data = {
            'category_process_val' : 'update_category',
            'update_category_id_val' : updateCategoryId,
            'update_category_name_val' : updateCategoryName,
            'update_category_active_val' : updateCategoryActive,
        }

        ShowLoader();

        $.ajax({
            url: '/category_process',
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
                
                if (response == 'category exists') {

                    Swal.fire({
                        icon: 'error',
                        title: 'Category Exists',
                        text: "The Category you entered already exists"
                    })
                    return false;
                    
                }
                
                Swal.fire({
                    icon: 'success',
                    title: "Category updated successfully",
                    text: "The category has been updated",
                    allowOutsideClick: false,
                    showCloseButton: false,
                }).then(function() {
                    window.location.reload(true);
                    $('#update_category_btn').modal('hide');
    
                    $('#update_category_id').val('');
                    $('#update_category_name').val('');
                });

            },
            error: function (result) {

                HideLoader();

                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
                return false;
            }
        });

    });

    $(document).on('click', '#filter_category_btn', function (e) {
        e.preventDefault();

        var filterCategoryName = $('#filter_category_name').val();
        var filterCategoryActive = $('#filter_category_active').val();

        if (filterCategoryName == '' && filterCategoryActive == '') {
            Swal.fire({
                icon: 'error',
                title: 'Filter Empty',
                text: "Please either enter data or select data to filter"
            });
            return false;
        }

        data = {
            'category_process_val' : 'filter_category',
            'filter_category_name_val' : filterCategoryName,
            'filter_category_active_val' : filterCategoryActive,
        }

        ShowLoader();

        $.ajax({
            url: '/category_process',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                $('.category_filter_body').html(response);
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
                    title: 'Some error',
                })
                return false;
            }
        });

    });
    
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
                    title: "Bank Account Added successfully",
                    text: "The bank account has been added",
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
                    title: 'Some error',
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
                    title: "Account updated successfully",
                    text: "The Account has been updated",
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
                    title: 'Some error',
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
                    title: 'Some error',
                })
                return false;
            }
        });

    });

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

        if (addIncomeDescription == '' ) {
            Swal.fire({
                icon: 'error',
                title: 'Income Description Empty',
                text: "Please enter income description to proceed"
            });
            return false;
        }

        data = {
            'income_process_val' : 'add_income',
            'add_income_bank_account_val' : addIncomeBankAccount,
            'add_income_source_val' : addIncomeSource,
            'add_income_amount_val' : addIncomeAmount,
            'add_income_description_val' : addIncomeDescription,
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
                    title: 'Some error',
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
                    title: 'Some error',
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
                    title: 'Some error',
                })
                return false;
            }
        });

    });

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
                    title: 'Some error',
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
                    title: 'Some error',
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
                    title: 'Some error',
                })
                return false;
            }
        });

    });


});