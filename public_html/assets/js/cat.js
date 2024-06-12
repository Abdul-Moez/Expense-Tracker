$( document ).ready(function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    function ShowLoader() {
        $('#big_loader').removeClass('d-none');
    }

    function HideLoader() {
        $('#big_loader').addClass('d-none');
    }

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
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
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
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
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
                    title: 'Oops, something went wrong.',
                    text: 'Please retry, and if the problem persists, please contact support.',
                })
                return false;
            }
        });

    });

});