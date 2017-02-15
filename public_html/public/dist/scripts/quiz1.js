/**
 * Created by vincentbeland on 17-02-14.
 */
var app = $(function configurer(evenement){
    var questionActive = 0;
    var pointage = 0;
    $("#progression").text("1/10");
    $('#validerQuiz').on("click", allerProchaineQuestion);
    for (var i = 1; i <= 9; i++) {
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
    function allerProchaineQuestion(evenement)
    {
        if (questionActive == 9) {
            if($("input[name=Q"+ questionActive + "]:checked").val() === undefined) {
                $("#retroaction").text("Veuillez sélectionner une réponse.");
                evenement.preventDefault();
            } else {
                return true;
            }
        } else {
            if($("input[name=Q"+ questionActive + "]:checked").val() === undefined) {
                $("#retroaction").text("Veuillez sélectionner une réponse.");
                evenement.preventDefault();
            } else {
                if (questionActive == 10) {
                    $("#retroaction").text("");
                } else {
                    evenement.preventDefault();
                    $("#retroaction").text("");
                    pointage = pointage + parseInt($("input[name=Q"+ questionActive + "]:checked").val());
                    questionActive++;
                    $("#progression").text((1 + questionActive).toString() + "/10");
                    reInitQuestion(questionActive);
                }
            }
        }
    }
});