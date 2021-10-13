@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $en_retard=false;
    if($la_tontine->caisse !=null){
        $prochaine_date_encaissement = $la_tontine->caisse->prochaine_date_encaissement;
        $en_retard = time() >= strtotime($prochaine_date_encaissement) ;
    }

@endphp


@extends('administrateur.base_administrateur')

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
                            @if($la_tontine->etat !='fermee' && $la_tontine->etat !='suspendue')
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
                        <li>Montant à cotiser : {{number_format($la_tontine->montant,0,',',' ')}} {{$la_tontine->createur->devise_choisie->monaie}} <small>par personnes</small> </li>
                        <li> Nombre de participant : {{sizeof($la_tontine->participants)}} / {{$la_tontine->nombre_participant}} </li>
                        @php
                            $montant_total = $la_tontine->montant * $la_tontine->nombre_participant;
                            $frais = round($montant_total * (1/100));
                        @endphp
                        <li>Frais de gestion (1%) : {{number_format($frais,0,',',' ')}} {{$la_tontine->createur->devise_choisie->monaie}} / {{number_format($montant_total,0,',',' ')}} {{$la_tontine->createur->devise_choisie->monaie}} </li>
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

                    <br/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <hr>
                        <h4 class="text-uppercase text-center"> Changer l'etat de la tontine </h4>
                    <hr>
                        <br/>
                        <p class="card-description">
{{--                            Entrez la liste des emails separés des virgules(,)--}}
                        </p>
                        <form class="forms-sample" method="post" action="{{route('admin.changer_etat_tontine',[$la_tontine['id']])}}">
                            <div class="form-group">
                                <h6 for="exampleInputUsername1">Etat de la tontine *</h6>
                                <select class="form-control" required name="nouvel_etat">
                                    <option selected value="{{$la_tontine->etat}}" >{{$la_tontine->etat}}</option>
                                    <option value="constitution">constitution</option>
                                    <option value="ouverte">ouverte</option>
                                    <option value="fermee" >fermee</option>
                                    <option value="suspendue" >suspendue</option>
                                </select>
                                <br/>
                                <h6>Motif</h6>
                                <textarea name="motif_intervention" class="form-control" rows="4"></textarea>
                            </div>
                            <h3 class="text-center">
                                @method('put')
                                @csrf
                                <button type="submit" class="btn btn-warning mr-2 text-white">Appliquer les changements</button>
                            </h3>
                        </form>

                </div>
            </div>
        </div>
    </div>

{{-- Cotisation et rotation --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >
                            Cotisation courante
                            @if($en_retard && $la_tontine->etat =='ouverte')
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
{{--                        <p>Montant Total Objectif : <span class="marquer_presence text-dark">{{number_format( ($la_tontine->montant * $la_tontine->nombre_participant),0,',',' ')}} F</span> </p>--}}
                        <p>Montant à cotiser : <b> {{number_format($la_tontine->montant,0,',',' ')}} {{$la_tontine->createur->devise_choisie->monaie}}</b> </p>
                        @if($la_tontine->etat =='ouverte')
                        <p>Date limite : <b class="badge badge-warning"> {{$la_tontine->caisse->prochaine_date_encaissement}} </b> </p>

                        <p>
                                    Montant en caisse : <span class="marquer_presence text-info">
                                        {{number_format($la_tontine->caisse->montant,0,',',' ')}} / {{number_format($la_tontine->caisse->montant_objectif,0,',',' ')}} {{$la_tontine->createur->devise_choisie->monaie}}
                                    </span>
                                </p>
                                <p> de : <small> de {{sizeof($liste_ayant_cotiser)}} personne(s)/{{sizeof($la_tontine->participants)}} <a href="#liste_cotiseur">Voir</a> </small> </p>
                            <br/>
                        @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >Liste des membres</h4>
                        <h6 class="text-center"> <small> dans l'ordre de rotation </small> </h6>
                    <hr/>
                    <table class="table table-bordered table-striped" >
                        <thead>
                            <th>#</th>
                            <th>Membre</th>
                            <th>#</th>
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
                                    <td>
                                        {{$item_particpant->nom_complet}}
                                        <h3>
                                            <span class="badge badge-{{$item_particpant->etat =='suspendu'? 'danger' : 'success'}}">{{$item_particpant->etat}}</span>
                                        </h3>
                                    </td>
                                    <td>
                                        <button type="button" onclick="deplier_garde_fou('garde_fou_menbre_{{$item_particpant['id']}}')">Agir</button>
                                        <div class="col-12 garde_fou" id="garde_fou_menbre_{{$item_particpant['id']}}">

                                            <form method="post" action="{{route('admin.suspendre_menbre',[$item_particpant['id']])}}">
                                                <br/>
                                                <h6>Etat du compte utilisateur</h6>
                                                <br/>
                                                    <select class="form-control" required name="nouvel_etat">
                                                        <option selected value="{{$item_particpant->etat}}" >{{$item_particpant->etat}}</option>
                                                        <option value="actif">actif</option>
                                                        <option value="suspendu">suspendu</option>
                                                    </select>
                                                <br/>
                                                    <h6>Motif</h6>
                                                    <br/>
                                                    <textarea name="motif_intervention" class="form-control" placeholder="Entrer le motif de votre intervention" rows="4">{{$item_particpant->motif_intervention_admin}}</textarea>
                                                <br/>
                                                @method('put')
                                                @csrf
                                                <button type="submit" class="btn btn-danger"> Appliquer les modifications</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($la_tontine->etat =='ouverte')
{{-- Liste des personnes ayants cotisee et statut invitation envoye --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card" id="liste_cotiseur">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                            <h4 class="text-center text-uppercase"> Personnes ayant payer leur cotisation pour le tour courant </h4>
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
                                        <td>{{date("d/m/Y H:i",strtotime($item_ayant_cotiser->updated_at))}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

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
                            <th>Envoyer par</th>
                            <th>Email Inviter</th>
                            <th>Statut</th>
                        </thead>
                        <tbody>
                            @foreach($invitations_envoyees as $item_envoyee)
                                <tr>
                                    <td>{{$item_envoyee->menbre_inviteur->nom_complet}}</td>
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
    @endif

    @if($la_tontine->caisse !=null)
        {{-- Liste des transactions sur la tontine --}}
        <div class="row">
        <div class="col-md-12 grid-margin stretch-card" >
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="text-center text-uppercase"> Toutes Les Transactions </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="datatable">
                        <thead>
                        <th>Menbre</th>
                        <th>Date paiement</th>
                        <th>Tour de</th>
                        <th>Rotation No</th>
                        <th>Statut</th>
                        </thead>
                        <tbody>
                        @foreach($transactions_de_la_tontine as $item_transaction)
                            <tr>
                                <td>{{$item_transaction->cotiseur->nom_complet}}</td>
                                <td>{{date("d/m/Y H:i",strtotime($item_transaction->updated_at))}}</td>
                                <td>{{$item_transaction->menbre_qui_prend->nom_complet}}</td>
                                <td>{{$item_transaction->tontine->caisse->index_ouverture}}</td>
                                <td class="text-{{($item_transaction->statut == 'ACCEPTED') ? 'success' : 'danger'}}"> [ {{$item_transaction->statut}} ]</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @endif

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
