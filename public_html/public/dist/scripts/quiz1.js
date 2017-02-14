/**
 * Created by vincentbeland on 17-02-14.
 */
var app = $(function configurer(evenement){
    var questionActive = 0;
    var pointage = 0;
    $('#validerQuiz').on("click", validerMonChoix);
    for (var i = 1; i <= 9; i++) {
        $("#Q" + i).hide();
    }

    /**
     * @param {int} no  -> le numéro de la question à afficher
     */
    function reInitQuestion(no){
        console.log(no);
        $("#Q" + (no - 1)).hide();
        $("#Q" + (no)).show();
    }

    function validerMonChoix(evenement){
        evenement.preventDefault();
        if($("input[name=Q"+ questionActive + "]:checked").val() == undefined) {
            $("#retroaction").text("Veuillez sélectionner une réponse.");
        } else {
            allerProchaineQuestion(evenement);
        }
    }

    function allerProchaineQuestion(evenement)
    {
        evenement.preventDefault();
        $("#retroaction").text("");
        pointage = pointage + parseInt($("input[name=Q"+ questionActive + "]:checked").val());
        questionActive++;
        reInitQuestion(questionActive)
        if (questionActive == 10) {
            $('#validerQuiz').remove();
            console.log(pointage * 2);
        }
    }
});