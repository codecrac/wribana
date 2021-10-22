@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);

    $statut_transaction = null;
    if(isset($_GET['statut_transaction'])){
        $statut_transaction = $_GET['statut_transaction'];
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

{{-- SECTION A propos de la crowd et invitaion  --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class='card-header'>
                    {!! Session::get('notification','') !!}
                    @if($statut_transaction !=null)
                        @if($statut_transaction == 'ACCEPTED')
                            <div class='alert alert-success text-center'>Votre paiement a bien été effectué</div>
                        @else
                            <div class='alert alert-danger text-center'>Echec du paiement</div>
                        @endif
                    @endif
                </div>
                <div class="card-body">
                    <hr/>
                        <h4 class="card-title text-center">
                            Waricrowd : {{$le_crowd->titre}}
                            <br/><br/>
                            <br/>
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    @if($le_crowd->createur->id == $la_session['id'])
                                        <a href="{{route('espace_menbre.editer_crowd',[$le_crowd['id']])}}" class="btn btn-success">Editer le waricrowd</a>
                                    @endif
                                </div>
                                @if($le_crowd->createur->id == $la_session['id'])
                                    @if(sizeof($le_crowd->transactions)==0)
                                            <div class="col-md-6 text-center">
                                                <a href="{{route('espace_menbre.supprimer_waricrowd',[$le_crowd['id']])}}"
                                                   class="btn btn-info">Supprimer le waricrowd</a>
                                            </div>
                                        @endif
                                @endif
                            </div>
                        </h4>
                    <hr/>
                    <ul>
                        @php
                            if($le_crowd->etat=='attente'){
                                $couleur = "dark";
                            }elseif($le_crowd->etat=='valider' or $le_crowd->etat =='terminer'){
                                $couleur = "success";
                            }else{
                                $couleur = "danger";
                            }
                        @endphp
                        <li>Categorie : {{$le_crowd->categorie->titre}} </li>
                        <li>Statut : <mark class="badge badge-{{$couleur}}">{{$le_crowd->etat}}</mark> </li>
                        <li>Crée par : {{$le_crowd->createur->nom_complet}}</li>
                        <li>Montant objectif : {{number_format($le_crowd->montant_objectif,0,',',' ')}} <b>{{$le_crowd->createur->devise_choisie->monaie}}</b> </li>

                        @php
                            $pourcentage = round($le_crowd->caisse->montant *100 / $le_crowd->caisse->montant_objectif,2);
                        @endphp

                        <li> Montant atteind : <b>{{$pourcentage}} %</b> [ {{number_format($le_crowd->caisse->montant,0,',',' ')}} F ]</li>
                        <li> Nombre de soutien : {{sizeof($le_crowd->transactions)}}</li>
                        <li> Creer le  : {{ date('d/m/Y',strtotime($le_crowd->created_at)) }}</li>

                    </ul>
                    <br/>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
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
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
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

        @if($le_crowd->etat=='valider')
            <div class="col-md-4 grid-margin">
                <div class="card">
                    <div class="card-header">
                        <hr/>
                           <h5 class="text-center">Soutenir le projet</h5>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <h5 class="text-center">Entrer le montant </h5>
                        <p class="text-center">
                            (en <b>{{$le_crowd->createur->devise_choisie->monaie}}</b>) 
                        </p>
                        
                        <form method="post" action="{{route('espace_menbre.confirmation_soutien_waricrowd')}}">
                            <div class="form-group">

                                <input class="form-control" type="hidden" name="id_crowd" value='{{$le_crowd->id}}' required/>
                                <input class="form-control" type="number" name="montant_soutien" placeholder="150000" min="1" required/>
                                <br/>
                                <h3 class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-primary"> Soutenir </button>
                                </h3>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h5 class="text-center"> Mes Transactions </h5>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <td>Date</td>
                        <td>Montant</td>
                        <td>Statut</td>
                        </thead>
                        <tbody>
                        @foreach($mes_transactions_pour_ce_crowd as $item_soutien)
                            <tr>
                                <td>{{date('d/m/Y H:i',strtotime($item_soutien['created_at']))}}</td>
                                <td>{{number_format($item_soutien->montant,0,',',' ')}} {{$item_soutien->waricrowd->createur->devise_choisie->monaie}}</td>
                                <td> {{$item_soutien->statut}} </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
