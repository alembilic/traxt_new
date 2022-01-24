$('.nav-burger-link').on('click', function(){
	$('.nav-burger-link').toggleClass('closed');
	$('.nav-menu').toggleClass('open');
	$('body').toggleClass('overflow-y-hidden');
	$('html').toggleClass('overflow-y-hidden');
	$('.page-wrapper').toggleClass('overflow-y-hidden');
})

$( '.js-input' ).keyup(function() {
  if( $(this).val() ) {
     $(this).addClass('not-empty');
  } else {
     $(this).removeClass('not-empty');
  }
});
$('.loop').owlCarousel({
    center: true,
    autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause:true,
    loop:true,
    margin:10,
    pagination: false,
    dots: false,
    smartSpeed: 1000,
    autoplaySpeed: 1500,
    touchDrag: true,
    responsive:{
        0:{
            items:1
        },
        768:{
            items:4
        },
        1000:{
            items:4
        }
    }
});
