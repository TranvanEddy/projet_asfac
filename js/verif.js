'use strict'
//vérif email
function checkEmail(email) {
    let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
//vérification de l'email a la connection admin
$('#formRegistration').on('submit', function (evenement) {
    let email = $('#email').val();
    if (!checkEmail(email)) {
        return;
    }
});
//vérifications a la soumission du formulaire de contact
$('#formRegistration2').on('submit', function (evenement) {
    let phone = $('#phone').val();
    let email = $('#email').val();
    let cv = $('#image').val();
    //phone
    if (parseInt(phone) != '') {
        if (phone.length != 10)//si l element est different de 10
        {
            evenement.preventDefault();
            alert('saisisez un numero a 10 chiffres');
            return;
        }
        if (isNaN(phone) == true)//si phone n'est pas un chiffre
        {
            evenement.preventDefault();
            alert("Un numéro de tel ne peut pas contenir de lettres ni de caractère speciaux");
            return;
        }
    }
    // vérif email
    if (!checkEmail(email)) {
        alert('Adresse e-mail non valide');
        evenement.preventDefault();
        return;
    }
    //cv
    if (cv != null) {
        if (cv.endsWith('.pdf') == false) {
            alert('seuls les fichiers pdf sont acceptés');
            evenement.preventDefault();
            return;
        }
    }
})
