$( document ).ready(function () {

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    function ShowLoader() {
        $('#big_loader').removeClass('d-none');
    }

    function HideLoader() {
        $('#big_loader').addClass('d-none');
    }

    HideLoader();

    $(document).on('click', "#sidebar-menu > ul > li", function() {
        var firstLi = $(this);
        var firstLiAnchor = firstLi.find("a");
        if (firstLiAnchor.find("span.menu-arrow").length == 0) {
            firstLi.addClass("active").siblings().removeClass("active");
            firstLi.prev().removeClass("active");
        }
        if ($(firstLi).hasClass('submenu')) {

        } else {
            $('.dashboard-content').addClass('d-none');
            $('.dashboard-iframe').removeClass('d-none');
        }
    });

    $(document).on('click', ".dashboard-iframe-links", function() {
        var urlLink = $(this).attr('href');
        var lastIndex = urlLink.lastIndexOf("?");
        var newUrl = urlLink.substring(0, lastIndex);

        $('title').text($(this).text().trim() + " - Expense Tracker");

        window.history.pushState('', '', newUrl)
    });

});