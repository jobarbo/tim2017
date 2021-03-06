/**
 * @author @evefevrier pour @TIMCSF
 * schema json pour structurer les données dynamiques d'un formulaire
 **/
var objMessagesJSON = {
    "connexion": {
        "echec": "Le nom d'utilisateur ou le mot de passe est incorrect. Veuillez réessayer."
    },
    "fiche_etudiant": {
        "img": {
            "permissions": "Les permissions d'écriture du dossier ne sont pas définies. Veuillez contacter l'administrateur du site.",
            "dossier": "Le dossier de destination est invalide. Veuillez contacter l'administrateur du site.",
            "poids": "Veuillez fournir un fichier qui ne dépasse pas la limite de poids permise (5Mo).",
            "type": "Veuillez fournir un fichier qui respecte le bon format (png).",
            "vide": "Veuillez sélectionner un fichier.",
            "taille": "Veuillez fournir un fichier qui respecte la limite de taille permise (800 x 360px).",
            "echec": "Votre nouvelle photo n'a pu être téléversée. Veuillez réessayer plus tard.",
            "succes": "Votre nouvelle photo est sauvegardée!"
        },
        "sauvegarde": {
            "succes": "Votre mise à jour a été effectuée avec succès!",
            "erreur": "Votre mise à jour n'a pas été effectuée. Veuillez réessayer."
        }
    }
};