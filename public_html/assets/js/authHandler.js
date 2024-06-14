$( document ).ready(function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

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

                setTimeout(() => {
                    window.location.assign('/encryption_key');
                }, 1000);

            },
            error: function (result) {
                $('#user-login-btn').removeClass('d-none');
                $('#login-loader').addClass('d-none');

                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
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

                setTimeout(() => {
                    window.location.assign('/encryption_key');
                }, 1000);

            },
            error: function (result) {
                $('#user-register-btn').removeClass('d-none');
                $('#register-loader').addClass('d-none');
                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
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

                // window.location.assign('/');

            },
            error: function (result) {
                $('#forogtPassBtn').removeClass('d-none');
                $('#forgotPass-loader').addClass('d-none');

                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
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

});
