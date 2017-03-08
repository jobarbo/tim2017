/**
 * Created by AnnabelleViolette on 17-02-18.
 */
$('.btn_tri').click(function () {
    event.preventDefault();
    $('#liste_diplomes').fadeTo(100, 0);
    $('.loader_wrapper').fadeIn(300);
    $('.liste_tri li a').removeClass('actif');

    console.log($(this).attr('id'));

    if($(this).attr('id') != "btn_reset_tri"){
        $(this).parent('li').children('a').addClass('actif');
    }

    $.ajax({
        type: 'GET',
        url: 'inc/scripts/trier_diplomes.php',
        data: 'tri_interets=' + $(this).attr('id'),

        success: function (data) {
            $('#liste_diplomes').html(data);

            setTimeout(function () {
                $('.loader-wrapper').hide();
                $('#liste_diplomes').fadeTo(200, 1);
            }, 1000);
        },

        error: function () {
            $('#diplomes_galerie').html('<p>Un erreur est survenue!</p>');
        },

    });
});