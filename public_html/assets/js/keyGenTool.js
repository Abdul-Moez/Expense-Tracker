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

    $(document).on('click', '#generate-key', function () {
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?';
        var code = '';
    
        for (var i = 0; i < 15; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            code += characters.charAt(randomIndex);
        }

        $('#generatedKey').val(code);
    });

    $(document).on('click', '#saveEncryptionKeyBtn', function (e) {
        e.preventDefault();

        var encryptionKey = $('#generatedKey').val().trim();

        if (encryptionKey == '') {
            Swal.fire({
                icon: 'error',
                title: 'Input Error',
                text: 'Please enter encryption key to continue',
            });
            return false;            
        }

        var data = {
            'encryptionKey_val': encryptionKey,
            'login_process_val': "encryption_key",
        };

        $('#encryptionKey-loader').removeClass('d-none');
        $('#saveEncryptionKeyBtn').addClass('d-none');

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
                if (response == 'key empty') {
                    $('#encryptionKey-loader').addClass('d-none');
                    $('#saveEncryptionKeyBtn').removeClass('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Input Error',
                        text: 'Please enter encryption key to continue',
                    });
                    return false;
                }
                if (response == 'wrong key') {
                    $('#encryptionKey-loader').addClass('d-none');
                    $('#saveEncryptionKeyBtn').removeClass('d-none');
                    Swal.fire({
                        icon: 'error',
                        title: 'Wrong Key',
                        text: "The entered key doesn't match your account",
                    });
                    return false;
                }

                if (response == 'go to dashboard') {
                    $('#encryptionKey-loader').addClass('d-none');
                    $('#saveEncryptionKeyBtn').removeClass('d-none');

                    $('#encryptionKey-success').removeClass('d-none');
                    $('#encryptionKey-success').html('Key matched, redirecting...');

                    setTimeout(() => {
                        window.location.assign('/dashboard');
                    }, 1000);
                    return false;
                }

                $('#encryptionKey-loader').addClass('d-none');
                $('#encryptionKey-success').removeClass('d-none');
                $('#encryptionKey-success').html('Your encryption key has been saved against your account, Save this key securely. If you lose it, your data cannot be recovered. This is a one-time setup. <br> Please click <a href="/dashboard"><i>here</i></a> to proceed.');

            },
            error: function (result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
                })
                $('#encryptionKey-loader').addClass('d-none');
                $('#saveEncryptionKeyBtn').removeClass('d-none');
                return false;                
            }
        });
    });
});