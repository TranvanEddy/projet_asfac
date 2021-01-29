'use strict'
let logo;
/*************************************************************************************************/
/* ***************************************** FONCTIONS ***************************************** */
/*************************************************************************************************/
//change l'attribut du logo au passage de la souris
function change() {
    $('.logoa').attr("src", 'img/logo_asfac.svg');
}
//repasse au logo initial a la sortie de la souris
function init() {
    $('.logoa').attr("src", 'img/logo_asfac1.svg');
}
//methode de récuperation des équipes 
function searchTeams(event) {
    event.preventDefault();
    let idSeason = $(".idSeason").val();
    let idLevel = $(".idLevel").val();
    //requète ajax
    $.post("index.php?controller=Teams&action=showTeams", { etIdSeason: idSeason, etIdLevel: idLevel }, displayListJson);
}
//récupération en json et affichage
function displayListJson(reponse) {
    //parser la reponse obtenu
    reponse = JSON.parse(reponse);
    $('#team').empty();
    if (reponse.length > 0) {
        for (let i = 0; i < reponse.length; i++) {
            reponse[i] = Object.values(reponse[i])
            $("#team").append(`<article class="detailTeam"><h2 >${reponse[i]['1']}</h2>
                            <p>${reponse[i]['5']}</p>
                            <img class="img" src="uploads/${reponse[i]['2']}"></article>`)
        }
    }
    //si rien ne correspond en bdd
    else {
        $("#team").append("<h3>pas d'équipe de cette categorie enregistée pour cette saison</h3>")
    }
}
/*************************************************************************************************/
/* ************************************** CODE PRINCIPAL *************************************** */
/*************************************************************************************************/
$(function () {
    $(document).on("submit", ".detail", searchTeams);
    $(".logoa").on("mouseenter", change);
    $(".logoa").on("mouseleave", init);
});


