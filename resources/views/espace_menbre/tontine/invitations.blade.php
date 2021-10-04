@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

@endphp



@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>
        .tr_bordered{
            border: 1px solid gray !important;
        }
    </style>
@endsection
@section('content')

{!! Session::get('notification','') !!}
    <hr/>
        <h3 class="text-center"> Invitations recues ( {{sizeof($invitation_recues)}} ) </h3>
    <hr/>

  <div class="row">
      <div class="table-responsive">
          <table class="table table-striped">
              <thead class="text-center">
                  <tr>
                      <th class="tr_bordered">Envoyée par</th>
                      <th class="tr_bordered">Tontine</th>
                      <th class="tr_bordered">Montant a cotiser</th>
                      <th class="tr_bordered">Frequence de depot</th>
                      <th class="tr_bordered">Statut</th>
                      <th class="tr_bordered">#</th>
                  </tr>
              </thead>
              <tbody class="text-center">
                  @foreach($invitation_recues as $item_iv_recue)

                      <tr>
                          <td class="tr_bordered">{{$item_iv_recue->menbre_inviteur->nom_complet}}</td>
                          <td class="tr_bordered">{{$item_iv_recue->tontine->titre}}</td>
                          <td class="tr_bordered">{{number_format($item_iv_recue->tontine->montant,0,',',' ')}} <b>{{$item_iv_recue->menbre_inviteur->devise_choisie->monaie}}</b> </td>
                          <td class="tr_bordered">{{formater_frequence($item_iv_recue->tontine->frequence_depot_en_jours)}}</td>
                          <td class="tr_bordered"><label class="badge badge-danger">{{$item_iv_recue['etat']}}</label></td>
                          <td class="tr_bordered">
                              <a href="#" onclick="deplier_garde_fou('garde_fou_recues_{{$item_iv_recue['id']}}')">Repondre</a>
                              <div class="col-12 garde_fou" id="garde_fou_recues_{{$item_iv_recue['id']}}">
                                  <form method="post" action="{{route('espace_menbre.reponse_invitation',[$item_iv_recue['id']])}}">
                                      <select class="form-control" name="reponse" required>
                                          <option value>(choisissez)</option>
                                          <option value="acceptee">Accepter</option>
                                          <option value="refusee">Refuser</option>
                                      </select>
                                      <br/>
                                      @csrf
                                      <input type="submit" value="valider" class="btn btn-warning">
                                  </form>
                              </div>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      </div>
  </div>
@endsection


@php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaine(s)";
            }
        }
        return $resultat;
    }
@endphp


@section('script_completmentaire')
    <script>
        window.onload = function() {
            fermer_tous_les_garde_fou();
        };

        function deplier_garde_fou(id){
            var le_garde_fou = document.getElementById(id);
            if(le_garde_fou.style.display =='none'){
                le_garde_fou.style.display = '';
            }else{
                le_garde_fou.style.display = 'none';
            }

        }

        function fermer_tous_les_garde_fou(){
            var tous_les_garde_fou = document.querySelectorAll('.garde_fou');
            for(var i=0; i<tous_les_garde_fou.length; i++){
                tous_les_garde_fou[i].style.display = "none";
            }
        }
    </script>
@endsection
