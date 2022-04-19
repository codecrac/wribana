
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

     @php
        if($le_crowd->etat=='valider'){
            $couleur= "success";
            $etat = "Validé";
        }elseif($le_crowd->etat=='recaler'){
            $couleur = "danger";
            $etat = "Recalé";
        }elseif($le_crowd->etat=='attente'){
            $couleur = "dark";
            $etat = "En attente";
        }elseif($le_crowd->etat=='terminer'){
            $couleur = "dark";
            $etat = "Terminé";
        }elseif($le_crowd->etat=='annuler'){
            $couleur = "dark";
            $etat = "Annulé";
        }
    @endphp

    {!! Session::get('notification','') !!}
    {{-- SECTION A propos de la crowd et invitaion  --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <hr/>
                    <h4 class="card-title text-center">
                        Waricrowd : {{$le_crowd->titre}}
                    </h4>
                    <hr/>
                    <ul>
                        <li>Statut : <mark class="badge badge-{{$couleur}}">{{$etat}}</mark> </li>
                        @if($le_crowd->motif_intervention_admin !=null) <li><b>Motif Intervention d'administrateur</b> : <mark class="badge badge-info">{{$le_crowd->motif_intervention_admin}}</mark> </li> @endif
                        <li>Crée par : {{$le_crowd->createur->nom_complet}}</li>
                        <li>Montant objectif : {{number_format($le_crowd->montant_objectif,0,',',' ')}}  <b>{{$le_crowd->createur->devise_choisie->monaie}}</b> </li>

                        @php
                            $pourcentage = round($le_crowd->caisse->montant *100 / $le_crowd->caisse->montant_objectif,2);
                            if($pourcentage <40){
                                $couleur= "danger";
                            }elseif($pourcentage <60){
                                $couleur = "warning";
                            }elseif($pourcentage <100){
                                $couleur = "info";
                            }else{
                                $couleur = "success";
                            }
                        @endphp

                        <li>
                            Montant atteind :
                            <span class="badge badge-{{$couleur}}">{{$pourcentage}} %</span> [ {{number_format($le_crowd->caisse->montant,0,',',' ')}}  <b>{{$le_crowd->createur->devise_choisie->monaie}}</b>  ]
                        </li>
                        <li> Nombre de soutien : {{sizeof($le_crowd->transactions)}}</li>
                        <li> Creer le  : {{ date('d/m/Y',strtotime($le_crowd->created_at)) }}</li>
                        
                        <br/>
                        <a href="{{route('admin.editer_crowd',[$le_crowd->id])}}" class='btn btn-warning' > Editer le crowd</a>

                    </ul>
                    <br/>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center">Validation du Projet</h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="post" action="{{route('admin.changer_etat_crowd',[$le_crowd['id']])}}">
                        <div class="form-group">
                            <h6 for="exampleInputUsername1">Etat du projet *</h6>
                            <select class="form-control" required name="nouvel_etat">
                                <option selected value="{{$le_crowd->etat}}" >{{$etat}}</option>
                                
                                
                                @if($le_crowd->etat != 'attente' ) <option value='attente'>En attente</option> @endif
                                @if($le_crowd->etat != 'valider' ) <option value='valider'>validé</option> @endif
                                @if($le_crowd->etat != 'recaler' ) <option value='recaler' >recalé</option> @endif
                                @if($le_crowd->etat != 'annuler' ) <option value="annuler">annulé la collecte</option> @endif
                                @if($le_crowd->etat != 'terminer' ) <option value='terminer'>terminé</option> @endif
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

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="text-center">Pitch Video</h4>
                    <hr/>
                </div>
                <div class="card-body">
                    @if($le_crowd->lien_pitch_video !=null)
                        <iframe width="100%" src="{{$le_crowd->lien_pitch_video}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    @else
                        <h3 class="text-center">
                            <img src="{{url($le_crowd->image_illustration)}}" style="max-width: 200px" />
                        </h3>
                    @endif
                </div>
                <div class="card-footer">
                    <hr/>
                    <h5>Description courte</h5>
                    <hr/>
                    <p class="text-center">
                        {{$le_crowd->description_courte}}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center">Description complete</h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <p>{!! $le_crowd->description_complete !!}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center">Liste des Transactions</h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="datatable">
                        <thead>
                        <td>Nom Complet</td>
                        <td>Montant</td>
                        <td>Date</td>
                        <td>Statut</td>
                        </thead>
                        <tbody>
                        @foreach($transactions_du_waricrowd as $item_soutien)
                            <tr>
                                <td>{{$item_soutien->souteneur->nom_complet}}</td>
                                <td>{{number_format($item_soutien->montant,0,',',' ')}} {{$item_soutien->waricrowd->createur->devise_choisie->monaie}}</td>
                                <td>{{date('d/m/Y H:i',strtotime($item_soutien['created_at']))}}</td>
                                <td class="text-{{($item_soutien->statut == 'ACCEPTED')? 'success' : 'danger'}}">[ {{$item_soutien->statut}} ]</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
