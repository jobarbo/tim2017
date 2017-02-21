/**
 * Created by vincentbeland on 17-02-21.
 */
var app = $(function configurer(evenement){

    var questionActive = 0;
    $("#progression").text("1/5");
    $('#validerQuiz').on("click", validerMonChoix);
    for (var i = 1; i <= 5; i++) {
        $("#Q" + i).hide();
        $("#qProfil" + i).hide();
    }
    /**
     * @param {int} no  -> le numéro de la question à afficher
     */
    function reInitQuestion(no){
        console.log(no);
        $("#Q" + (no - 1)).hide();
        $("#Q" + (no)).show();
        $("#qProfil" + (no - 1)).hide();
        $("#qProfil" + (no)).show();
    }

    function validerMonChoix(evenement)
    {
        if($("input[name=Q"+ questionActive + "]:checked").val() === undefined) {
            $("#retroaction").text("Veuillez sélectionner une réponse.");
            evenement.preventDefault();
        } else {

        }
    }

    function allerProchaineQuestion(evenement)
    {
        function allerProchaineQuestion(evenement)
        {
            evenement.preventDefault();
            $('#questionSuivante').remove();
            reInitQuestion(questionActive);
        }
    }

});