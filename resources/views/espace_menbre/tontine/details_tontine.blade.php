@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $en_retard=false;
    if($la_tontine->caisse !=null){
        $prochaine_date_encaissement = $la_tontine->caisse->prochaine_date_encaissement;
        $en_retard = time() >= strtotime($prochaine_date_encaissement) ;
    }

@endphp


@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>
        .marquer_presence{
            font-size: 18px;
            font-weight:bold;
        }
    </style>
@endsection

@section('content')

    {!! Session::get('notification','') !!}
{{-- SECTION A propos de la tontine et invitaion  --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <hr/>
                        <h4 class="card-title text-center">
                            Tontine : {{$la_tontine->titre}}
                            @if($la_tontine->createur->id == $la_session['id'])
                                <a href="{{route('espace_menbre.editer_tontine',[$la_tontine['id']])}}" class="btn btn-warning">Editer la tontine</a>
                            @endif
                            <br/>
                            @if($la_tontine->etat !='fermee')
                                @if($en_retard)
                                    <span class="clignote badge badge-danger">
                                            Cotisation en retard
                                        </span>
                                @endif
                            @endif
                        </h4>
                    <hr/>
                    <ul>
                        <li>Statut : <mark class="badge badge-{{$la_tontine->etat=='ouverte' ? 'success' :'danger'}}">{{$la_tontine->etat}}</mark> </li>
                        @if($la_tontine->motif_intervention_admin !=null) <li><b>Motif Intervention d'administrateur</b> : <mark class="badge badge-info">{{$la_tontine->motif_intervention_admin}}</mark> </li> @endif
                        <li>Crée par : {{$la_tontine->createur->nom_complet}}</li>
                        <li>Montant à cotiser : {{number_format($la_tontine->montant,0,',',' ')}} F <small>par personnes</small> </li>
                        @php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = round($montant_total * (1/100));
                        @endphp
                        <li>Montant Objectif : {{number_format($montant_total,0,',',' ')}} F </li>
                        <li>Frais de gestion (1%) : {{number_format($frais,0,',',' ')}} F / {{number_format($montant_total,0,',',' ')}} F </li>
                        <li> Nombre de participant : {{sizeof($la_tontine->participants)}} / {{$la_tontine->nombre_participant}} </li>
                        <li> Frequence de depot : {{formater_frequence($la_tontine->frequence_depot_en_jours)}}</li>
                        <li> Tour de :
                            <mark class="badge badge-primary marquer_presence">
                                @if($la_tontine->caisse !=null)
                                    {{$la_tontine->caisse->menbre_qui_prend->nom_complet}}
                                @else
                                    #
                                @endif
                            </mark>
                        </li>

                    </ul>


                    @if($la_tontine->createur->id == $la_session['id'] && $la_tontine->etat =='constitution' ||  $la_tontine->etat =='prete')
                         <p class="badge badge-info">La tontine pourra être ouverte une fois le nombre de participant specifié atteinds.</p>
                        @if($pret)
                            <form method="post" action="{{route('espace_menbre.ouvrir_tontine',[$la_tontine['id']])}}">
                                @if($la_tontine->createur->id == $la_session['id'])
                                    @csrf
                                   <h3 class="text-center">
                                       <p class="badge badge-warning">Ouvrez la tontine uniquement si vous êtes pret a commencer les cotisations.</p>
                                       <button type="submit" class="btn btn-success">Ouvrir la tontine</button>
                                   </h3>
                                @endif
                            </form>
                        @else
                            <h3 class="text-center">
                                <input type="button" class="btn btn-dark" style="cursor: not-allowed" value="Ouvrir la tontine" />
                            </h3>
                        @endif
                    @endif

                    <br/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if($la_tontine->etat !='fermee')
                <div class="card">
                <div class="card-body">
                    <hr>
                        <h4 class="text-uppercase text-center"> Inviter des amis </h4>
                    <hr>
                    @if(sizeof($la_tontine->participants) < $la_tontine->nombre_participant)
                        <br/>
                        <p class="card-description">
                            Code invitation : <b>{{$la_tontine->identifiant_adhesion}}</b> (a entrer dans la section <b>adherer via code d'ivitation</b> sur le tableau de bord )
                            au personnes a inviter
                            <br/><br/>
                            ou Entrez la liste des emails separés des virgules(,)
                        </p>
                        <form class="forms-sample" method="post" action="{{route('espace_menbre.post_inviter_des_amis',[$la_tontine['id']])}}">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Liste des Emails</label>
                                <input required type="text" class="form-control" name="liste_emails" placeholder="adresse1@gmail.com,adresse2@gmail.com">
                            </div>
                            <h3 class="text-center">
                                @csrf
                                <button type="submit" class="btn btn-primary mr-2">Envoyer les invitations</button>
                            </h3>
                        </form>
                    @else
                        <h3 class="text-center"> <b class="badge badge-success">Complet !</b></h3>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

{{-- Cotisation et rotation --}}
    @if($la_tontine->etat =='ouverte')
        <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >
                            Cotisation courante
                            @if($en_retard)
                                <span class="clignote badge badge-danger">
                                    Cotisation en retard
                                </span>
                            @endif
                        </h4>
                    <hr/>
                    <br/>
                        <p>Tour de :
                            <b class="badge badge-info marquer_presence">
                                @if($la_tontine->caisse !=null)
                                    {{$la_tontine->caisse->menbre_qui_prend->nom_complet}}
                                @else
                                    #
                                @endif
                            </b>
                        </p>
                        <p>Date limite : <b class="badge badge-warning"> {{$la_tontine->caisse->prochaine_date_encaissement}} </b> </p>
{{--                        <p>Montant Total Objectif : <span class="marquer_presence text-dark">{{number_format( ($la_tontine->montant * $la_tontine->nombre_participant),0,',',' ')}} F</span> </p>--}}
                        <p>Montant à cotiser : <b> {{number_format($la_tontine->montant,0,',',' ')}} F</b> </p>
                        <p>
                            Montant en caisse : <span class="marquer_presence text-info">
                                {{number_format($la_tontine->caisse->montant,0,',',' ')}} / {{number_format($la_tontine->caisse->montant_objectif,0,',',' ')}} F
                            </span>
                        </p>
                        <p> de : <small> de {{sizeof($liste_ayant_cotiser)}} personne(s)/{{sizeof($la_tontine->participants)}} <a href="#liste_cotiseur">Voir</a> </small> </p>
                    <br/>
                        @if($a_deja_cotiser)
                        <h5 class="text-center"> <b style="padding: 15px" class="badge-success">Vous avez dejà payer votre cotisation pour ce tour.</b> </h5>
                        @else
                            <h3 class="text-center">
                                <form action="{{route('espace_menbre.paiement_cotisation',[$la_tontine->id])}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-primary" style="">Payer ma cotisation</button>
                                </form>
                            </h3>
                        @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >Ordre de rotation</h4>
                        <h6 class="text-center"> <small> par date d'adhesion </small> </h6>
                    <hr/>
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <th>#</th>
                            <th>Menbre</th>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                            @foreach($la_tontine->participants as $item_particpant)
                                <tr>
                                    <td>
                                        @if($la_tontine->caisse !=null)
                                            <b class="{{$la_tontine->caisse->menbre_qui_prend->id == $item_particpant->id ? 'badge badge-info' : '' }}">
                                                {{$i++}}
                                            </b>
                                        @endif
                                    </td>
                                    <td>{{$item_particpant->nom_complet}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

{{-- Liste des personnes ayants cotisee et statut invitation envoye --}}
    <div class="row">
        @if($la_tontine->etat =='ouverte')
            <div class="col-md-6 grid-margin stretch-card" id="liste_cotiseur">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                            <h4 class="text-center text-uppercase"> Personnes ayant payer leur cotisation </h4>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>Menbre</th>
                                <th>Date paiement</th>
                            </thead>
                            <tbody>
                                @foreach($liste_ayant_cotiser as $item_ayant_cotiser)
                                    <tr>
                                        <td>{{$item_ayant_cotiser->cotiseur->nom_complet}}</td>
                                        <td>{{date("d/m/Y H:m",strtotime($item_ayant_cotiser->updated_at))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="text-center text-uppercase"> Invitations envoyees </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Email</th>
                            <th>Statut</th>
                        </thead>
                        <tbody>
                            @foreach($invitations_envoyees as $item_envoyee)
                                <tr>
                                    <td>{{$item_envoyee->email_inviter}}</td>
                                    <td>
                                        @php
                                            $couleur = "primary";
                                            if($item_envoyee->etat == "acceptee"){
                                                $couleur = "success";
                                            }elseif($item_envoyee->etat == "refusee"){
                                                $couleur = "danger";
                                            }elseif($item_envoyee->etat == "expiree"){
                                                $couleur = "dark";
                                            }
                                        @endphp
                                        <b class="badge badge-{{$couleur}}"> {{$item_envoyee->etat}} </b>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaines";
            }
        }
        return $resultat;
    }
@endphp
