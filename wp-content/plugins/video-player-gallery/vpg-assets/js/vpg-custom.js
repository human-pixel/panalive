jQuery(document).ready(function($) {
	$( '.vpg-video-outer' ).each(function( index ) {		
		var popup_id   = $(this).attr('id');
		var popup_conf = $.parseJSON( $(this).find('.wp-vpg-popup-conf').text());
		if( typeof(popup_id) != 'undefined' ) {
			jQuery('#'+popup_id+ ' .popup-youtube').magnificPopup({					 
				type: 'iframe',
				mainClass: 'mfp-fade vpg-mfp-zoom-in vpg-popup-main-wrp',
				removalDelay: 160,					
				preloader: false,
				fixedContentPos: popup_conf.popup_fix == 'true' ? true : 0,
				gallery: {
						enabled: (popup_conf.popup_gallery == "true") ? true : false,
			          },				
			});			
			jQuery('#'+popup_id+ ' .popup-modal').magnificPopup({					 					 
				mainClass: 'mfp-fade vpg-popup-main-wrp',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: popup_conf.popup_fix == 'true' ? true : 0,
				gallery: {
						enabled: (popup_conf.popup_gallery == "true") ? true : false,
			          },
				callbacks: {
				  close: function(){
					vpg_simple_pause_video();
				  }
			  },
			});
		}
	});	
});
/* Function for pause video */
function vpg_simple_pause_video() {
	jQuery('.vpg-wrap .wp-hvgp-video-frame').each(function( index ) {
		if (!jQuery(this).get(0).paused) {
			jQuery(this).get(0).pause();
		}
	});
}
jQuery( document ).ready(function($) {
  // Logo Slider
  $( '.vpg-video-slider' ).each(function( index ) {    
    var slider_id   = $(this).attr('id');
    var vpg_conf   = $.parseJSON( $(this).closest('.vpg-slider-outer').find('.vpg-video-slider-js-call').attr('data-conf') );
    if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
        jQuery('#'+slider_id).slick({
            centerMode      : (vpg_conf.center_mode) == "true" ? true : false,
            dots            : (vpg_conf.dots) == "true" ? true : false,
            arrows          : (vpg_conf.arrows) == "true" ? true : false,
            infinite        : (vpg_conf.loop) == "true" ? true : false,
            speed           : parseInt(vpg_conf.speed),
            autoplay        : (vpg_conf.autoplay) == "true" ? true : false,
            slidesToShow    : parseInt(vpg_conf.slides_column),
            slidesToScroll  : parseInt(vpg_conf.slides_scroll),
            autoplaySpeed   : parseInt(vpg_conf.autoplay_interval),
            pauseOnFocus    : false,
            adaptiveHeight: (vpg_conf.auto_height) == "true" ? true : false,
            draggable: false,
            prevArrow: "<div class='slick-prev'><i class='fa fa-angle-left'></i></div>",
            nextArrow: "<div class='slick-next'><i class='fa fa-angle-right'></i></div>",
            centerPadding       : '0px',
           mobileFirst         : (Vpg.is_mobile == 1) ? true : false,
            responsive: [{
              breakpoint: 1023,
              settings: {
                slidesToShow  : (parseInt(vpg_conf.slides_column) > 3) ? 3 : parseInt(vpg_conf.slides_column),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 640,
              settings: {
                slidesToShow  : (parseInt(vpg_conf.slides_column) > 2) ? 2 : parseInt(vpg_conf.slides_column),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 479,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 319,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }]
      });
    }
  });
});
jQuery( document ).ready(function($) { 
	// video playlist
  $( '.playlist-slider-for' ).each(function( index ) { 
    var slider_id   = $(this).attr('id');
    var playlist_conf   = $.parseJSON( $(this).closest('.playlist-vpg-slider-outter').find('.playlist-vpg-video-slider-js-call').attr('data-conf') );
    if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
        jQuery('#'+slider_id).slick({
            centerMode      : (playlist_conf.center_mode) == "true" ? true : false,
            dots            : (playlist_conf.dots) == "true" ? true : false,
            arrows          : (playlist_conf.arrows) == "true" ? true : false,
            infinite        : (playlist_conf.loop) == "true" ? true : false,
            speed           : parseInt(playlist_conf.speed),
            autoplay        : (playlist_conf.autoplay) == "true" ? true : false,
            slidesToShow    : 1,
            slidesToScroll  : 1,
            autoplaySpeed   : parseInt(playlist_conf.autoplay_interval),
            pauseOnFocus    : false,
            draggable: false,
            prevArrow: "<div class='slick-prev'><i class='fa fa-angle-left'></i></div>",
            nextArrow: "<div class='slick-next'><i class='fa fa-angle-right'></i></div>",
            centerPadding       : '0px',
            mobileFirst         : (Vpg.is_mobile == 1) ? true : false,
            adaptiveHeight: (playlist_conf.auto_height) == "true" ? true : false,
            asNavFor: '.playlist-slider-nav',
            responsive: [{
              breakpoint: 1023,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 640,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 479,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 319,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }]
      });
$('.playlist-slider-nav').slick({ 
  slidesToShow:  parseInt(playlist_conf.playlist_row),
  slidesToScroll: 1,
  asNavFor: '.playlist-slider-for',
  centerMode: (playlist_conf.center_mode) == "true" ? true : false,
  focusOnSelect: true,
  vertical: true,
  touchMove: true,
  infinite: true,
  swipe: true,
  autoplay:false,
  dots: false,
  arrows: (playlist_conf.playlist_arrow) == "true" ? true : false,
  prevArrow: "<div class='slick-prev'><i class='fa fa-angle-up'></i></div>",
  nextArrow: "<div class='slick-next'><i class='fa fa-angle-down'></i></div>",
   responsive: [{
              breakpoint: 1023,
              settings: {
                slidesToShow  : (parseInt(playlist_conf.playlist_row) > 3) ? 3 : parseInt(playlist_conf.playlist_row),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 640,
              settings: {
                slidesToShow  : (parseInt(playlist_conf.playlist_row) > 2) ? 2 : parseInt(playlist_conf.playlist_row),
                slidesToScroll  : 1
              }
            },{
              breakpoint: 479,
              settings: {
                slidesToShow  : 1,
                slidesToScroll  : 1
              }
            },{
              breakpoint: 319,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }]
   
});
    }
  });
$( '.vpg-platlist-video-outer' ).each(function( index ) {		
		var popup_id   = $(this).attr('id');
		var popup_conf = $.parseJSON( $(this).find('.wp-vpg-popup-conf').text());		    
		    	jQuery('.playlist-popup-youtube').magnificPopup({					 
				type: 'iframe',
				mainClass: 'mfp-fade vpg-mfp-zoom-in vpg-popup-main-wrp',
				removalDelay: 160,					
				preloader: false,
				fixedContentPos:true,
				gallery: {
						enabled:false,
			          },				
			});			
			jQuery('.playlist-popup-modal').magnificPopup({					 					 
				mainClass: 'mfp-fade vpg-popup-main-wrp',
				removalDelay: 160,
				preloader: false,
				fixedContentPos:true,
				gallery: {
						enabled: false,
			          },
				callbacks: {
				  close: function(){
					vpg_simple_pause_video();
				  }
			  },
			});		
	});	
});