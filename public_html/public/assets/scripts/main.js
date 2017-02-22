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


    $('input.navbox').on('change', function () {
      $('input.navbox').not(this).prop('checked', false);
    });


    var previousScroll = 0,
      headerOrgOffset = $('.meta_nav').height();
      console.log(headerOrgOffset);

    //$('header').height($('.meta_nav').height());

    $(window).scroll(function () {
      var currentScroll = $(this).scrollTop();
      if (currentScroll > headerOrgOffset) {
        if (currentScroll > previousScroll) {
          console.log(currentScroll);
          $('.hide_nav').slideUp();
          
          console.log(previousScroll);
        } else {
          console.log(previousScroll);
          $('.hide_nav').slideDown();
        }
      } else {
        console.log("top");
        
        $('.hide_nav').slideDown();
      }
      previousScroll = currentScroll;
    });
  }
  window.onload = configurer;


})(jQuery); // Fully reference jQuery after this point.
