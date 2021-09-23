require('./bootstrap');
import Alpine from 'alpinejs';


alert('ok');
// const btn_envoyer_le_message = document.getElementById('btn_envoyer_le_message');
const id_menbre_connecter = document.getElementById('id_menbre_connecter');
const div_all_message = document.getElementById('div_all_message');
const message_input = document.getElementById('message');
const id_tontine_input = document.getElementById('id_tontine');
const formulaire_envoi_message = document.getElementById('formulaire_envoi_message');

formulaire_envoi_message.addEventListener('submit',function(e){
    e.preventDefault();
    let has_errors = false;

    if(message_input.value==''){
        alert("Le message ne peut pas etre vide, si tu n'as rien n'a dire nous emmerde pas");
        has_errors = true;
    }

    if(has_errors){
        return;
    }

    let id_tontine = id_tontine_input.value;
    let url_envoi_message = "/espace-menbre/chat/"+id_tontine;
    const options = {
        method : 'post',
        url : url_envoi_message,
        data :{
            message : message_input.value
        }
    }
    axios(options);
});


//pour gerer l'emplacement des messages en fonction de l'utilisateur connecter
//estque c'est lui qui envoi le message



let debut_un_message ='<div class="conteneur_de_message"> <div class="un_message">';
let debut_mon_message ='<div class="conteneur_de_message"> <div class="mon_message">';
let debut_auteur = '<span class="auteur"> <b>';
let fin_auteur_debut_message = '</b> <small>a écrit :</small> </span><h6>'
let fin_message = '</h6></div></div>';


window.Echo.channel('waribana')
    .listen('.message-tontine',(e)=>{
        let la_div_a_rajouter = debut_un_message;
        if(id_menbre_connecter.value == e.id_menbre){
            la_div_a_rajouter = debut_mon_message;
        }

        la_div_a_rajouter += debut_auteur + e.nom_complet_menbre + fin_auteur_debut_message + e.message + fin_message;
        div_all_message.innerHTML += la_div_a_rajouter;
        console.log(e);
    });



window.Alpine = Alpine;

Alpine.start();
