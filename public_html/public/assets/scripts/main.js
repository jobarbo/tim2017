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

(function($) {



  $(document).ready(function() {

  });



  function configurer() {

    $( ".etudiant" ).click(function() {

      $( ".second_nav.sub_etudiant" ).slideToggle( "slow" );
    });
    $( ".programme" ).click(function() {

      $( ".second_nav.sub_programme" ).slideToggle( "slow" );
    });
    $( ".stages" ).click(function() {

      $( ".second_nav.sub_stages" ).slideToggle( "slow" );
    });



}
  window.onload = configurer;
  

})(jQuery); // Fully reference jQuery after this point.
