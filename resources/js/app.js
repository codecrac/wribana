require('./bootstrap');
import Alpine from 'alpinejs';


// alert('ok');
const id_tontine_input = document.getElementById('id_tontine');


//rafraichhir liste des menbre en ligne
setInterval(function () {
    // alert('go check');
    axios.get('/espace-menbre/qui-est-en-ligne/'+id_tontine_input.value,)
        .then(function (response) {
            document.getElementById('qui_est_en_ligne')
                .innerHTML =response.data ;
        }); // do nothing for error - leaving old content.
}, 1000 * 60); // milliseconds


// const btn_envoyer_le_message = document.getElementById('btn_envoyer_le_message');
const id_menbre_connecter = document.getElementById('id_menbre_connecter');
const div_all_message = document.getElementById('div_all_message');
const message_input = document.getElementById('message');
const formulaire_envoi_message = document.getElementById('formulaire_envoi_message');

formulaire_envoi_message.addEventListener('submit', function (e) {
    e.preventDefault();
    let has_errors = false;

    if (message_input.value == '') {
        alert("Le message ne peut pas etre vide, si tu n'as rien n'a dire nous emmerde pas");
        has_errors = true;
    }

    if (has_errors) {
        return;
    }


    let id_tontine = id_tontine_input.value;
    message_input.value = message_input.value.replaceAll('\n', '<br/>');
    let url_envoi_message = "/espace-menbre/chat/" + id_tontine;
    const options = {
        method: 'post',
        url: url_envoi_message,
        data: {
            message: message_input.value
        }
    }
    axios(options);
    message_input.value = '';
    div_all_message.scrollTop = div_all_message.scrollHeight;

});


//pour gerer l'emplacement des messages en fonction de l'utilisateur connecter
//estque c'est lui qui envoi le message


let debut_un_message = '<div class="conteneur_de_message"> <div class="un_message">';
let debut_mon_message = '<div class="conteneur_de_message"> <div class="mon_message">';
let debut_auteur = '<span class="auteur"> <b>';
let fin_auteur_debut_message = '</b> <small>a écrit :</small> </span><h6>'
let fin_message_debut_timestamp = '</h6><small>';
let fin_timestamp = '</small></div></div>';


window.Echo.channel('waribana')
    .listen('.message-tontine', (e) => {
        // alert('vous avez un nouveau message');

        if (id_tontine_input.value == e.id_tontine) { //pour ne pas affiche les messages des autre tontine vu qu'on a une seul channel de brodcast
            let la_div_a_rajouter = debut_un_message;
            if (id_menbre_connecter.value == e.id_menbre) {
                la_div_a_rajouter = debut_mon_message;
            }


            var currentdate = new Date();
            var datetime = currentdate.getDate() + "-"
                + (currentdate.getMonth() + 1) + "-"
                + currentdate.getFullYear() + "  "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes();

            la_div_a_rajouter += debut_auteur + e.nom_complet_menbre + fin_auteur_debut_message + e.message + fin_message_debut_timestamp + datetime + fin_timestamp;
            div_all_message.innerHTML += la_div_a_rajouter;
            div_all_message.scrollTop = div_all_message.scrollHeight;
            console.log(e);
        }
    });


window.Alpine = Alpine;

Alpine.start();
