/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function ($) {



  $(document).ready(function () {

  });

  function configurer() {

    $('#svg_logo').addClass("big_svg");
    $('#logo_text').addClass("big_text");
    $('input.navbox').on('change', function () {
      $('input.navbox').not(this).prop('checked', false);
    });


    var previousScroll = 0,
      headerOrgOffset = $('.meta_nav').height();
    

    //$('header').height($('.meta_nav').height());
$(window).scroll(function () {
      console.log("checkSize");
      if ($(".meta_nav").css("height") != "29px") {
        
          var currentScroll = $(this).scrollTop();
          if (currentScroll > headerOrgOffset) {
            if (currentScroll > previousScroll) {
              
              $('.hide_nav').slideUp();
              $('#svg_logo').removeClass("big_svg");
              $('#logo_text').removeClass("big_text");

            } else {

              $('.hide_nav').slideDown();
              $('#svg_logo').addClass("big_svg");
              $('#logo_text').addClass("big_text");
            }
          } else {
            $('.hide_nav').slideDown();
            $('#svg_logo').addClass("big_svg");
            $('#logo_text').addClass("big_text");
          }
          previousScroll = currentScroll;
       
      }

    
 });

  }
  window.onload = configurer;


})(jQuery); // Fully reference jQuery after this point.