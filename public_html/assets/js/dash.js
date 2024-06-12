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

    $(document).on('click', '#edit-prof-toggle-cur-password', function () {
        $('#edit-prof-toggle-cur-password').toggleClass('fa-eye-slash fa-eye');
        $('#edit_prof_curr_pass').attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password';
        });
    });

    $(document).on('click', '#edit-prof-toggle-new-password', function () {
        $('#edit-prof-toggle-new-password').toggleClass('fa-eye-slash fa-eye');
        $('#edit_prof_new_pass').attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password';
        });
    });

    $(document).on('click', '#edit-prof-toggle-cnfrm-new-password', function () {
        $('#edit-prof-toggle-cnfrm-new-password').toggleClass('fa-eye-slash fa-eye');
        $('#edit_prof_cnfrm_new_pass').attr('type', function (_, attr) {
            return attr === 'password' ? 'text' : 'password';
        });
    });
    
    $(document).on('click', '#update_prof_info', function (e) {
        e.preventDefault();

        var updateUserProfName = $('#edit_prof_name').val().trim();
        var updateUserProfEmail = $('#edit_prof_email').val().trim();
        var updateUserProfCurPass = $('#edit_prof_curr_pass').val().trim();
        var updateUserProfNewPass = $('#edit_prof_new_pass').val().trim();
        var updateUserProfCnfrmNewPass = $('#edit_prof_cnfrm_new_pass').val().trim();

        if (updateUserProfName == '') {
            Swal.fire({
                icon: 'error',
                title: "Name can't be empty",
            })
            return false;
        }
        if (updateUserProfEmail == '') {
            Swal.fire({
                icon: 'error',
                title: "Email can't be empty",
            })
            return false;
        }

        if (updateUserProfCurPass == '' && updateUserProfNewPass != '' && updateUserProfCnfrmNewPass != '') {
            Swal.fire({
                icon: 'error',
                text: "Current password can't be empty",
            })
            return false;
        }

        if (updateUserProfCurPass != '' && updateUserProfNewPass != '' && updateUserProfCnfrmNewPass == '') {
            Swal.fire({
                icon: 'error',
                text: "Confirm new password can't be empty",
            })
            return false;
        }

        if (updateUserProfCurPass != '' && updateUserProfNewPass == '' && updateUserProfCnfrmNewPass != '') {
            Swal.fire({
                icon: 'error',
                text: "New password can't be empty",
            })
            return false;
        }

        if (updateUserProfCurPass != '' && updateUserProfNewPass == '' && updateUserProfCnfrmNewPass == '') {
            Swal.fire({
                icon: 'error',
                text: "Please enter new password and confirm new password",
            })
            return false;
        }

        if (updateUserProfCurPass == '' && updateUserProfNewPass != '' && updateUserProfCnfrmNewPass == '') {
            Swal.fire({
                icon: 'error',
                text: "Please enter current password and confirm new password",
            })
            return false;
        }

        if (updateUserProfCurPass == '' && updateUserProfNewPass == '' && updateUserProfCnfrmNewPass != '') {
            Swal.fire({
                icon: 'error',
                text: "Please enter current password and new password",
            })
            return false;
        }

        if (updateUserProfNewPass != '' && updateUserProfCnfrmNewPass != '') {
            if (updateUserProfNewPass != updateUserProfCnfrmNewPass) {
                Swal.fire({
                    icon: 'error',
                    title: 'Not Same Password',
                    text: 'Password and confirm password are not same',
                })
                return false;
            }
        }

        if (updateUserProfCurPass != '' && updateUserProfNewPass != '' && updateUserProfCnfrmNewPass != '') {
            if (updateUserProfCurPass == updateUserProfNewPass && updateUserProfCurPass == updateUserProfCnfrmNewPass) {
                Swal.fire({
                    icon: 'error',
                    title: 'Not different password',
                    text: 'New password should not be same as current password',
                })
                return false;
            }            
        }

        if (IsEmail(updateUserProfEmail) == false) {
            Swal.fire({
                icon: 'error',
                title: 'InValid Email',
                text: 'Please enter valid email',
            })
            return false;
        }

        ShowLoader();

        data = {
            'updateUserProfName_val' : updateUserProfName,
            'updateUserProfEmail_val' : updateUserProfEmail,
            'updateUserProfCurPass_val' : updateUserProfCurPass,
            'updateUserProfNewPass_val' : updateUserProfNewPass,
            'updateUserProfCnfrmNewPass_val' : updateUserProfCnfrmNewPass,
            'dash_process_val' : 'update_prof_data',
        }

        $.ajax({
            url: '/dash_process',
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

                if (response == "updated") {
                    Swal.fire({
                        icon: 'info',
                        title: 'Profile Updated!',
                        text: 'Your profile has been updated successfully!',
                        timerProgressBar: 'true',
                        timer: '2500',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                    })
                    function redirect() {
                        window.location.reload();
                    }
                    setTimeout(redirect, 2400);
                }

                if (response == 'curr pass empty') {
                    Swal.fire({
                        icon: 'error',
                        text: "Current password can't be empty",
                    })
                    return false;
                }

                if (response == 'cnfrm pass empty') {
                    Swal.fire({
                        icon: 'error',
                        text: "Confirm new password can't be empty",
                    })
                    return false;
                }

                if (response == 'new pass empty') {
                    Swal.fire({
                        icon: 'error',
                        text: "New password can't be empty",
                    })
                    return false;
                }

                if (response == 'new password and confirm new password') {
                    Swal.fire({
                        icon: 'error',
                        text: "Please enter new password and confirm new password",
                    })
                    return false;
                }

                if (response == 'current password and confirm new password') {
                    Swal.fire({
                        icon: 'error',
                        text: "Please enter current password and confirm new password",
                    })
                    return false;
                }

                if (response == 'current password and new password') {
                    Swal.fire({
                        icon: 'error',
                        text: "Please enter current password and new password",
                    })
                    return false;
                }

                if (response == 'pass same as old pass') {
                    Swal.fire({
                        icon: 'error',
                        text: "Password can't be same as old password",
                    })
                    return false;
                }

                HideLoader();

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
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
                })
                return false;
            }
        });

    });
});