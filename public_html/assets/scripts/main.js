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
    configurer();
  });



  function configurer() {
    resizeMenu();

    function resizeMenu() {
      if ($(window).width() <= 769 && $(window).width() >= 551) {
        $('#etudiant').click(function () {

          if ($('#etudiant').is(':checked')) {
            $(".menu_etudiant").css("height", "245px");
            $(".menu_programme").css("height", "50px");
            $(".menu_stages").css("height", "50px");

          } else {
            $('.menu_etudiant').css('height', "50px");
          }
        });
        $('#programme').click(function () {

          if ($('#programme').is(':checked')) {
            $('.menu_programme').css("height", "167px");
            $(".menu_etudiant").css("height", "50px");
            $(".menu_stages").css("height", "50px");

          } else {
            $('.menu_programme').css("height", "50px");
          }
        });
        $('#stages').click(function () {

          if ($('#stages').is(':checked')) {
            $('.menu_stages').css("height", "167px");
            $(".menu_etudiant").css("height", "50px");
            $(".menu_programme").css("height", "50px");

          } else {
            $('.menu_stages').css("height", "50px");
          }
        });
      }
      if ($(window).width() <= 550) {
        $('#etudiant').click(function () {

          if ($('#etudiant').is(':checked')) {
            $(".menu_etudiant").css("height", "215px");
            $(".menu_programme").css("height", "45px");
            $(".menu_stages").css("height", "45px");

          } else {
            $('.menu_etudiant').css('height', "45px");
          }
        });
        $('#programme').click(function () {

          if ($('#programme').is(':checked')) {
            $('.menu_programme').css("height", "147px");
            $(".menu_etudiant").css("height", "45px");
            $(".menu_stages").css("height", "45px");

          } else {
            $('.menu_programme').css("height", "45px");
          }
        });
        $('#stages').click(function () {

          if ($('#stages').is(':checked')) {
            $('.menu_stages').css("height", "147px");
            $(".menu_etudiant").css("height", "45px");
            $(".menu_programme").css("height", "45px");

          } else {
            $('.menu_stages').css("height", "45px");
          }
        });
      }
    }

    $('#svg_logo').addClass("big_svg");
    $('#logo_text').addClass("big_text");

    $('input.navbox').on('change', function () {
      $('input.navbox').not(this).prop('checked', false);
    });

    var previousScroll = 0,
      headerOrgOffset = $('.meta_nav').height();


    $(window).resize(function () {
      resizeMenu();

    });

    //$('header').height($('.meta_nav').height());
    $(window).scroll(function () {
      console.log($(".meta_nav").css("height"));
      if ($(".meta_nav").css("height") > "26px") {




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