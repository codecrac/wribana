@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <a class="btn btn-success" href="{{route('espace_menbre.ajouter_tontine')}}">Creer une tontine</a>
    </div>

    <br/><br/>

  <div class="row">
      <table width="100%" border="1">
          <thead class="text-center">
                <th style="padding: 5px">Titre</th>
                <th>Nombres de particpants</th>
                <th>Montant à cotiser</th>
                <th>Frequence de cotisation</th>
                <th>Tour de</th>
                <th>Creer par</th>
                <th>#</th>
          </thead>
          <tbody>
              @foreach($mes_tontines as $ma_tontine)
                  <tr>
                      <td style="padding: 5px">{{$ma_tontine['titre']}}</td>
                      <td>{{$ma_tontine['nombre_participant']}}</td>
                      <td>{{$ma_tontine['montant']}}</td>
                      <td>{{formater_frequence($ma_tontine['frequence_depot_en_jours'])}}</td>
                      <td>Tour de</td>
                      <td>
                          {{$ma_tontine->createur->nom_complet}}
                      </td>
                      <td class="text-center" style="padding: 8px">
                          <a href="#" class="btn btn-primary" style="">Payer ma cotisation</a>
                          <a href="{{route('espace_menbre.inviter_des_amis',[$ma_tontine['id']])}}" class="btn btn-secondary">Inviter des amis</a>

                          @if($ma_tontine->createur->id == $la_session['id'])
                            <a href="{{route('espace_menbre.editer_tontine',[$ma_tontine['id']])}}" class="btn btn-warning">Editer la tontine</a>
                          @endif
                      </td>
                  </tr>
              @endforeach
          </tbody>
          <tfoot class="text-center">
              <th>Titre</th>
              <th>Nombres de particpants</th>
              <th>Montant à cotiser</th>
              <th>Frequence de cotisation</th>
              <th>Tour de</th>
              <th>Creer par</th>
              <th>#</th>
          </tfoot>
      </table>
  </div>
@endsection


@php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7 ==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaines";
            }
        }
        return $resultat;
    }
@endphp
