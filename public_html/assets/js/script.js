$( document ).ready(function () {

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
});