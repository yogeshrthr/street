$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.fixed-header').addClass('bg-light');
            $('.secondary-nav-wrapper').addClass('text-dark');
        }
        if ($(this).scrollTop() < 50) {
            $('.fixed-header').removeClass('bg-light');
            $('.secondary-nav-wrapper').removeClass('text-dark');
        }
    });
});
function slideBackground(el) {
    $('.primary-nav-panel').removeClass('d-none');
    $('.primary-nav-item').not(el).css('font-weight','500');
    $('#navItem_'+$(el).data("nav-id")).css('font-weight','600');
    $(el).css('font-weight','600');
    $('#primaryNavItem_'+$(el).data("nav-id")).css('font-weight','600');
    var imagePath = 'uploads/category/'+$(el).data("nav-background");
    $('.slider-section').css('background-image','url('+imagePath+')');
    $('.nav-burger-bar:first').addClass('rotated-first-nav-switch');
    $('.nav-burger-bar:last').addClass('rotated-last-nav-switch');
    $('.nav-panel-links-wrap').addClass('d-none');
    $('#navLink_'+$(el).data("nav-id")+'').removeClass('d-none');
}
function closeNavPanel() {
    // if(!($('.primary-nav-panel').hasClass('d-none'))) {
    //     $('.primary-nav-panel').addClass('d-none');
    // }
}
function toggleNavPanel() {
    if($('.primary-nav-panel').hasClass('d-none')) {
        $('.primary-nav-panel').removeClass('d-none');
        $('.nav-burger-bar:first').addClass('rotated-first-nav-switch');
        $('.nav-burger-bar:last').addClass('rotated-last-nav-switch');
    }else {
        $('.primary-nav-panel').addClass('d-none');
        $('.nav-burger-bar:first').removeClass('rotated-first-nav-switch');
        $('.nav-burger-bar:last').removeClass('rotated-last-nav-switch');
    }
}