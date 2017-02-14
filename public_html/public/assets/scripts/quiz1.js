/**
 * Created by vincentbeland on 17-02-14.
 */
var app = $(function configurer(evenement){

    var questionActive = 0;
    var pointage = 0;
    /* Configuration: ajouts des écouteurs d'événements et état initial de l'app */
    reInitQuestion(questionActive);

    $( "fieldset" ).each(function( index ) {
        $("#Q" + index).hide();
    });

    /**
     * @param {int} no  -> le numéro de la question à afficher
     */

    function reInitQuestion(no){

    }

    function validerMonChoix(evenement){
        evenement.preventDefault();
    }
    function allerProchaineQuestion(evenement)
    {
        evenement.preventDefault();
        questionActive++;
        reInitQuestion(questionActive)
    }

    /* Autres fonctions? ... */

    function commencerQuiz(evenement)
    {
        evenement.preventDefault();
        $('#commencer').remove();
        questionActive++;
        $('#Q0').hide();
        reInitQuestion(questionActive);
    }

});