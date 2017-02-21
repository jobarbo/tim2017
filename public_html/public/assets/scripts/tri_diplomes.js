/**
 * Created by AnnabelleViolette on 17-02-18.
 */
$('.btnTri').click(function () {
    event.preventDefault();
    $('#liste_diplomes').fadeTo(100, 0);
    $('.loaderWrapper').fadeIn(300);
    $('.listeTri li').removeClass('actif');

    if($(this).attr('id') != "btnResetTri"){
        $(this).parent('li').addClass('actif');
    }

    $.ajax({
        type: 'GET',
        url: 'inc/scripts/trier_diplomes.php',
        data: 'tri_interets=' + $(this).attr('id'),

        success: function (data) {
            $('#liste_diplomes').html(data);

            setTimeout(function () {
                $('.loaderWrapper').hide();
                $('#liste_diplomes').fadeTo(200, 1);
            }, 1000);
        },

        error: function () {
            $('#diplomes_galerie').html('<p>Un erreur est survenue!</p>');
        },

    });
});