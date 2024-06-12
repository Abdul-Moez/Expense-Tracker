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
                    Swal.fire({
                        title: 'Wrong Email!',
                        text: "The Email you provided doesn't exist, please enter correct Email and then try again.",
                        icon: 'error',
                    })
                    return false;
                }

                if(response == "Wrong password") {
                    Swal.fire({
                        title: 'Wrong Password!',
                        text: "The Credentials you provided doesn't match any account, please enter correct credentials and then try again.",
                        icon: 'error',
                    })
                    return false;
                }

                window.location.assign('/dashboard');

            },
            error: function (result) {
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
                    Swal.fire({
                        icon: 'error',
                        title: 'Email Exists!',
                        text: "The Email you provided already exist, please enter correct another and or login.",
                    })
                    return false;
                }

                window.location.assign('/dashboard');

            },
            error: function (result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Some error',
                })
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

});