/**
 * Created by vincentbeland on 17-02-21.
 */
var app = $(function configurer(evenement) {
    $("#progression").removeClass("no-js");
    $('#validerQuiz').hide();
    var questionActive = 0;
    $("#progression").html("<span class='total'>1</span>/5");
    for (var i = 1; i <= 5; i++) {
        $("#Q" + i).hide();
    }

    /* Configuration: ajouts des écouteurs d'événements et état initial de l'app */
    var $qo = "";
    var $qn = "";
    var bon = 0;

    var $q0o = "Oui, Tim te permettra d’apprendre à concevoir et réaliser des éléments visuels et sonores de toutes sortes à l’aide de logiciels professionnels, sur plateforme Mac et PC avec par exemple la suite professionnelle d’Adobe.";
    var $q0n = "Attention, le programme Tim comporte un important pourcentage de cours dédiés à la conception et réalisation d’éléments visuels et sonores de toutes sortes à l’aide de logiciels professionnels, sur plateforme Mac et PC avec par exemple la suite professionnelle d’Adobe.";
    var $q1o = "Oui, Tim te permettra d'apprendre à programmer des pages Web et des produits interactifs à l'aide de langages de programmation. Les langages de programmation utilisés sont par exemple : JavaScript et PHP.";
    var $q1n = "Attention, le programme Tim comporte un important pourcentage de cours dédiés à la programmation de pages web et de produits interactifs. Les langages de programmation utilisés sont par exemple : JavaScript et PHP.<";
    var $q2o = "Non, Tim ne te permettra pas d’apprendre des notions reliées au domaine de la télédiffusion. Tout au plus, tu auras un cours de 60 heures dédié à la captation et au montage audiovidéo au cours de tes trois années de formation. Il existe des programmes spécialisés dans le domaine des communications, par exemple : http://www.cegepjonquiere.ca/arts-lettres-et-communication.html";
    var $q2n = "En effet, TIM ne te permettra pas d’apprendre des notions reliées au domaine de la télédiffusion. Tout au plus, tu auras un cours de 60 heures dédié à la captation et au montage audio-vidéo au cours de tes trois années de formation.";
    var $q3o = "Non, très peu. Tout au plus, tu auras un cours de 45 heures dédié à l'apprentissage de l'animation dans un contexte de diffusion pour le Web. Il existe des programmes spécialisés dans le domaine du 3D, par exemple: http://www.cegeplimoilou.ca/formations/diplomes-d-etudes-collegiales-dec-technique/574b0-animation-3d-et-synthese-d-images/";
    var $q3n = "En effet, très peu. Tout au plus, tu auras un cours de 45 heures dédié à l'apprentissage de l'animation dans un contexte de diffusion pour le Web.";
    var $q4o = "Non, Tim ne te permettra pas de développer des compétences en lien avec l’imprimé et l’illustration. Il existe des programmes spécialisés dans le domaine du Graphisme, par exemple : http://www.cegep-ste-foy.qc.ca/programmes/programmes-techniques/graphisme/";
    var $q4n = "En effet, Tim ne te permettra pas de développer des compétences en lien avec l’imprimé et l’illustration. Il existe des programmes spécialisés dans le domaine du Graphisme, par exemple : http://www.cegep-ste-foy.qc.ca/programmes/programmes-techniques/graphisme/";

    reInitQuestion(questionActive);
    /**
     * @param {int} no  -> le numéro de la question à afficher
     */
    function reInitQuestion(no) {
        switch (no) {
            case 0:
                $qo = $q0o;
                $qn = $q0n;
                bon = 0;
                break;
            case 1:
                $qo = $q1o;
                $qn = $q1n;
                bon = 0;
                break;
            case 2:
                $qo = $q2o;
                $qn = $q2n;
                bon = 1;
                break;
            case 3:
                $qo = $q3o;
                $qn = $q3n;
                bon = 1;
                break;
            case 4:
                $qo = $q4o;
                $qn = $q4n;
                bon = 1;
                break;
        }

        console.log(no);
        if (no > 0) {
            $("#progression").html("<span class='total'>" + (no + 1).toString() + "</span>/5");
        }
        $("#explication").text("");
        $("#explication").removeClass();
        $("#icone-explication").html("");
        $("#icone-explication").removeClass();
        $("#Q" + (no - 1)).hide();
        if (no > 0)
        {
            slideQuiz(no);
        }
        else
        {
            $("#Q" + (no)).show();
        }
        /*$("#qProfil" + (no - 1)).hide();
         $("#qProfil" + (no)).show();*/
        $('#Q' + no).after("<input id='validerQuestion' class='btnQuizBleu' name='validerQuestion' type='submit' value='Valider mon choix' />");
        $('#validerQuestion').on("click", validerMonChoix);
    }

    function slideQuiz(no)
    {
        $("#Q" + (no)).slideToggle({easing: "swing"});
    }
    function validerMonChoix(evenement)
    {
        $("#retroaction").text("");
        $("#icone-explication").html("");
        $("#icone-explication").removeClass();
        evenement.preventDefault();
        if($("input[name=Q"+ questionActive + "]:checked").val() === undefined)
        {
            $("#retroaction").text("Veuillez sélectionner une réponse.");
            $("#icone-explication").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
            $("#icone-explication").addClass("mauvais");
        }
        else
        {
            if($("input[name=Q"+ questionActive + "]:checked").val() == "Oui" && questionActive < 2)
            {
                $("#explication").text($qo);
                $("#explication").addClass("bon");
                $("#icone-explication").html('<i class="fa fa-check" aria-hidden="true"></i>');
                $("#icone-explication").addClass("bon");
            }
            else
            {
                if($("input[name=Q"+ questionActive + "]:checked").val() == "Non" && questionActive >= 2)
                {
                    $("#explication").text($qn);
                    $("#explication").addClass("bon");
                    $("#icone-explication").html('<i class="fa fa-check" aria-hidden="true"></i>');
                    $("#icone-explication").addClass("bon");
                }
                else
                {
                    if($("input[name=Q"+ questionActive + "]:checked").val() == "Oui" && questionActive >= 2)
                    {
                        $("#explication").text($qo);
                        $("#explication").addClass("mauvais");
                        $("#icone-explication").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
                        $("#icone-explication").addClass("mauvais");
                    }
                    else
                    {
                        $("#explication").text($qn);
                        $("#explication").addClass("mauvais");
                        $("#icone-explication").html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
                        $("#icone-explication").addClass("mauvais");
                    }
                }
            }

            $("input[name=Q" + questionActive + "]").attr('disabled', 'disabled');
            $('#validerQuestion').remove();

            if (questionActive < 4)
            {
                $('#Q' + questionActive).after("<input id='questionSuivante' class='btnQuizBleu' name='questionSuivante' type='submit' value='Question suivante' />");
                $('#questionSuivante').on("click", allerProchaineQuestion);
            }
            else
            {
                $("input[type='radio']").removeAttr('disabled');
                $('#validerQuiz').show();
            }
        }
    }

    function allerProchaineQuestion(evenement)
    {
        evenement.preventDefault();
        questionActive++;
        $('#questionSuivante').remove();
        reInitQuestion(questionActive);
    }
});