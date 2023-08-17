$( document ).ready(function () {

    // Admin Script Starts here
    $(document).on('click', '#admin-logout', function () {

        $.ajax({
            url: '/admin_logout',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            success: function (response) {

                window.location.assign('/admin');

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

    

    $(document).on('click', '#admin-login-btn', function () {

        var getAdminEmail = $('#admin-email').val();
        var getAdminPass = $('#admin-password').val();


        if (getAdminEmail == '') {
            Swal.fire({
                icon: 'error',
                title: "Email can't be empty",
            })
            return false;
        }
        if (getAdminPass == '') {
            Swal.fire({
                icon: 'error',
                title: "Pass can't be empty",
            })
            return false;
        }

        if (isValidEmail(getAdminEmail) == false) {
            Swal.fire({
                icon: 'error',
                title: 'InValid Email',
                text: 'Please enter valid email',
            })
            return false;
        }

        data = {
            'adminEmail_val' : getAdminEmail,
            'adminPass_val' : getAdminPass,
        }


        $.ajax({
            url: '/admin_login',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: data,
            success: function (response) {

                if(response == "account closed") {
                    Swal.fire({
                        title: 'Account Closed!',
                        text: "The account you are trying to access has been closed if you have a question please contact us.",
                        icon: 'error',
                    })
                    return false;
                }

                if(response == "Wrong email or password") {
                    Swal.fire({
                        title: 'Wrong Creds!',
                        text: "The Credentials you provided doesn't exist in our database, please enter correct credentials and then try again.",
                        icon: 'error',
                    })
                    return false;
                }

                window.location.assign('/admin/dashboard');

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
});