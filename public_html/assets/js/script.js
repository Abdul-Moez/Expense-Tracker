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
                $('#big_loader').addClass('d-none');
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


});