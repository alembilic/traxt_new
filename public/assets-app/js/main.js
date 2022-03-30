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
});
