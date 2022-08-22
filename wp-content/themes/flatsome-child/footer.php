<?php
/**
 * The template for displaying the footer.
 *
 * @package flatsome
 */

global $flatsome_opt;
?>

</main>

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer>

</div>
 <!-- <script src="<?php echo get_stylesheet_directory_uri()?>/js/jquery.min.js"></script> -->
<?php wp_footer(); ?>

<!-- <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri()?>/js/slick.js"></script> -->
<script type="text/javascript">
  jQuery(document).ready(function($) {
    jQuery(document).on("click","a.rl-gallery-link", function() {
          var lght_img = $(this).attr("href");
          var cap = $(this).find(".rl-gallery-item-caption").html();
          if(cap == undefined){
            var cap = "No Caption Available";
          }
        $("body").append('<div class="lightbox_overlay"><div class="lightbox_inn"><span class="light_popupp_close">x</span><img src="'+lght_img+'" alt=""><div class="light_popupp_caption">'+cap+'</div> <span class="light_popup_prev">Prev</span><span class="light_popup_next">Next</span></div></div>');
        $(this).parent(".rl-gallery-item").addClass("rl-gallery-item-opened");
        return false;

      });
    $(document).on("click",".light_popupp_close", function() {
      $(".lightbox_overlay").remove();
      $(".rl-gallery-item").removeClass("rl-gallery-item-opened");
    });
    $(document).on("click",".light_popup_next", function() {
      $(".rl-gallery-item.rl-gallery-item-opened").each(function(){
        if( $(this).is(':last-child')){
          var light_img = $(this).parents(".owl-item").next(".owl-item").find(".rl-gallery-item:first-child").find("img").attr("src");
          var light_cap = $(this).parents(".owl-item").next(".owl-item").find(".rl-gallery-item:first-child .rl-gallery-item-caption").text();
          $(this).removeClass("rl-gallery-item-opened");
          if(light_img == undefined) {
            var light_img = $(".owl-item:first-child").find(".rl-gallery-item:first-child").find("img").attr("src");
            var light_cap = $(".owl-item:first-child").find(".rl-gallery-item:first-child .rl-gallery-item-caption").text();
           
            $(".owl-item:first-child").find(".rl-gallery-item:first-child").addClass("rl-gallery-item-opened");
          } else {
             $(this).parents(".owl-item").next(".owl-item").find(".rl-gallery-item:first-child").addClass("rl-gallery-item-opened");
          }
          if(light_cap == 0){
            var light_cap = "No Caption Available";
          }
          $(".lightbox_inn").find("img").attr("src", light_img);
          $(".light_popupp_caption").html(light_cap);
        }  else {
          var light_img = $(this).next(".rl-gallery-item").find("img").attr("src");
          var light_cap = $(this).next(".rl-gallery-item").find(".rl-gallery-item-caption").text();
          if(light_cap == 0){
            var light_cap = "No Caption Available";
          }
          $(this).removeClass("rl-gallery-item-opened");
          $(this).next(".rl-gallery-item").addClass("rl-gallery-item-opened");
          $(".lightbox_inn").find("img").attr("src", light_img);
          $(".light_popupp_caption").html(light_cap);
        }

      });
    });
    $(document).on("click",".light_popup_prev", function() {
      $(".rl-gallery-item.rl-gallery-item-opened").each(function(){
        if( $(this).is(':first-child')){
          var light_img = $(this).parents(".owl-item").prev(".owl-item").find(".rl-gallery-item:last-child").find("img").attr("src");
          
          
          $(this).removeClass("rl-gallery-item-opened");
          /*$(this).parents(".owl-item").prev(".owl-item").find(".rl-gallery-item:last-child").addClass("rl-gallery-item-opened");
            */

          if(light_img == undefined) {
            var light_img = $(".owl-item:last-child").find(".rl-gallery-item:last-child").find("img").attr("src");
            var light_cap = $(".owl-item:last-child").find(".rl-gallery-item:last-child .rl-gallery-item-caption").text();
           
            $(".owl-item:last-child").find(".rl-gallery-item:last-child").addClass("rl-gallery-item-opened");
          } else {
            var light_cap = $(this).parents(".owl-item").prev(".owl-item").find(".rl-gallery-item:last-child .rl-gallery-item-caption").text();
             $(this).parents(".owl-item").prev(".owl-item").find(".rl-gallery-item:last-child").addClass("rl-gallery-item-opened");

          }

          if(light_cap == 0){
            var light_cap = "No Caption Available";
          }

          $(".lightbox_inn").find("img").attr("src", light_img);
          $(".light_popupp_caption").html(light_cap);
        }  else {
          var light_img = $(this).prev(".rl-gallery-item").find("img").attr("src");
          var light_cap = $(this).prev(".rl-gallery-item").find(".rl-gallery-item-caption").text();
          if(light_cap == 0){
            var light_cap = "No Caption Available";
          }
          $(this).removeClass("rl-gallery-item-opened");
          $(this).prev(".rl-gallery-item").addClass("rl-gallery-item-opened");
          $(".lightbox_inn").find("img").attr("src", light_img);
          $(".light_popupp_caption").html(light_cap);
        }

      });
    });
    });


  function myFunction() {
  var dots = document.getElementById("dots");
  var moreText = document.getElementById("more");
  var btnText = document.getElementById("readMorePlus");

  if (dots.style.display === "none") {
    dots.style.display = "inline";
    btnText.innerHTML = "Read More +";
    moreText.style.display = "none";
  } else {
    dots.style.display = "none";
    btnText.innerHTML = "Read less -";
    moreText.style.display = "inline";
  }
}

 	jQuery(document).ready(function() {
//     jQuery(window).scroll(function(){
//   var sticky = jQuery('#header.header'),
//       scroll = jQuery(window).scrollTop();

//   if (scroll >= 100) sticky.addClass('header-fixed');
//   else sticky.removeClass('header-fixed');
// });
//     jQuery(window).scroll(function(){
//   var sticky1 = jQuery('#header.header'),
//       scroll1 = jQuery(window).scrollTop();

//   if (scroll1 >= 200) sticky1.addClass('header-fixed2');
//   else sticky1.removeClass('header-fixed2');
// });


var owl = jQuery('#lumixSSerirs_slider');
owl.owlCarousel({
    items : 4,
    loop:true,
    margin:0,
    nav:true,
    pagination:true,
    dots:true,
    responsive:{
        0:{ items:1 },
        600:{ items:1 },
        768:{ items:2 },
        992:{ items:3 },
        1024:{ items:3 }
    }
});
jQuery('.next').click(function(){
  owl.trigger('owl.next');
});
jQuery('.prev').click(function(){
  owl.trigger('owl.prev');
});

var owl2 = jQuery('#lumixSSerirs_slider_body');
owl2.owlCarousel({
    items : 4,
    loop:true,
    margin:10,
    nav:false,
    pagination:true,
    dots:true,
    responsive:{
        0:{ items:1 },
        600:{ items:1 },
        768:{ items:2 },
        992:{ items:3 },
        1024:{ items:4 }
    }
});
jQuery('.SCnext').click(function(){
  owl2.trigger('owl.next');
});
jQuery('.SCprev').click(function(){
  owl2.trigger('owl.prev');
});

var owl3 = jQuery('#lumixGSerirs_slider_body');
owl3.owlCarousel({
    items : 4,
    loop:true,
    margin:10,
    nav:false,
    pagination:true,
    dots:true,
    responsive:{
        0:{ items:1 },
        600:{ items:1 },
        768:{ items:2  },
        992:{ items:3 },
        1024:{ items:4 }
    }
});
 jQuery('.GCnext').click(function(){
   owl3.trigger('owl.next');
 });
 jQuery('.GCprev').click(function(){
   owl3.trigger('owl.prev');
 });
/****lumix g series***/
var owlCar = jQuery('#lumixGSerirs_slider');
owlCar.owlCarousel({
    items : 4,
    loop:true,
    margin:10,
    nav:true,
    pagination:true,
    dots:true,
    responsive:{
        0:{ items:1 },
        600:{ items:1 },
        768:{ items:2 },
        992:{ items:3 },
        1024:{ items:3 }
    }
});
jQuery('.Gnext').click(function(){
    owlCar.trigger('owl.next');
});
jQuery('.Gprev').click(function(){
    owlCar.trigger('owl.prev');
});
    // Params

});
</script>



<script type="text/javascript">
//   $('#slick1').slick({
//     rows: 2,
//     dots: false,
//     arrows: true,
//     infinite: true,
//     speed: 300,
//     slidesToShow: 3,
//     slidesToScroll: 3,
//     responsive: [
//         {
//           breakpoint: 767,
//           settings: {
//             slidesToShow: 2,
//             slidesToScroll: 2,
//             adaptiveHeight: true,
//           },
//         },
//         {
//           breakpoint: 600,
//           settings: {
//             slidesToShow: 1,
//             slidesToScroll: 1,
//           },
//         },
//       ],
// });
var owlgallery = jQuery('#lumix_gallery_slider');
owlgallery.owlCarousel({
    items : 1,
    loop:true,
    margin:10,
    nav:true,
    pagination:false,
    dots:false,
    responsive:{
        0:{ items:1 },
        600:{ items:1 },
        768:{ items:1 },
        992:{ items:1 },
        1024:{ items:1 }
    }
});
jQuery('.gallerynext').click(function(){
    owlgallery.trigger('owl.next');
});
jQuery('.galleryprev').click(function(){
    owlgallery.trigger('owl.prev');
});
</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-3872066-31"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-3872066-31');
</script>
</body>
</html>
