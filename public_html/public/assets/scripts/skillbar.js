/**
 * Created by AnnabelleViolette on 17-02-18.
 */
jQuery(document).ready(function () {
    jQuery('.barre_progression').each(function () {
        jQuery(this).find('.barre_interet').animate({
            width: jQuery(this).attr('data-percent')
        }, 4000);
    });
});