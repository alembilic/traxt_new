$(function(){
    // Sidebar
    $('.sidebar-btn').on('click', function(e){
        $('.sidebar').toggleClass('sidebar-open');
        setCookie('sidebar', $('.sidebar').hasClass('sidebar-open'))
        e.preventDefault();
    })

    // Sub Menu
    $('.sidebar .has-sub-menu > span').on('click', function(){
        $(this).parent('.has-sub-menu').toggleClass('sub-menu-open');
    })

    if (getCookie('sidebar')) {
        $('.sidebar').toggleClass('sidebar-open');
    }

    //Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    $('body').on('change','.new-url-modal .form-switch .form-check-input', function(){
        $('.new-url-modal .extended-input').toggleClass('active')
    });

    $('input[name="daterange"]').daterangepicker({
        "locale": {
            "format": "YYYY-MM-DD",
            "separator": "               ",
            "applyLabel": "Ok",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "weekLabel": "W",
            "daysOfWeek": [
                "Sun",
                "Mon",
                "Tue",
                "Wed",
                "Thu",
                "Fri",
                "Sat"
            ],
            "monthNames": [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec"
            ],
            "firstDay": 1
        }
    });
});
