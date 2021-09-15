@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp


@extends('espace_menbre.base_espace_menbre')

@section('content')

{{-- SECTION A propos de la tontine et invitaion  --}}
    <div class="row">
        {!! Session::get('notification','') !!}
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <hr/>
                        <h4 class="card-title text-center">
                            Tontine : {{$la_tontine->titre}}
                            @if($la_tontine->createur->id == $la_session['id'])
                                <a href="{{route('espace_menbre.editer_tontine',[$la_tontine['id']])}}" class="btn btn-warning">Editer la tontine</a>
                            @endif
                        </h4>
                    <hr/>
                    <ul>
                        <li>Statut : <mark class="badge badge-{{$la_tontine->etat=='ouverte' ? 'success' :'danger'}}">{{$la_tontine->etat}}</mark> </li>
                        <li>Crée par : {{$la_tontine->createur->nom_complet}}</li>
                        <li>Montant à cotiser : {{number_format($la_tontine->montant,0,',',' ')}} F <small>par personnes</small> </li>
                        <li> Nombre de participant : {{sizeof($la_tontine->participants)}} / {{$la_tontine->nombre_participant}} </li>
                        <li> Tour de : <mark class="badge badge-primary"> qui </mark> </li>
                    </ul>
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
                            Entrez la liste des emails separés des virgules(,)
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
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <hr/>
                        <h4 class="text-center text-uppercase" >Cotisation courante</h4>
                    <hr/>
                    <br/>
                        <h5>Tour de : <b class="badge badge-info"> sdkj lksjd </b> </h5>
                        <h5>Montant à cotiser : {{number_format($la_tontine->montant,0,',',' ')}}F </h5>
                        <h5> Montant en caisse : {{number_format(46437,0,',',' ')}}F </h5>
                        <h5> de : <small> de 0 personnes/{{sizeof($la_tontine->participants)}} <a href="#liste_cotiseur">Voir</a> </small> </h5>
                    <br/>
                        <h3 class="text-center">
                            <a href="#" class="btn btn-primary" style="">Payer ma cotisation</a>
                        </h3>
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
                    <table class="table table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Menbre</th>
                        </thead>
                        <tbody>
                        @php $i=1; @endphp
                            @foreach($la_tontine->participants as $item_particpant)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$item_particpant->nom_complet}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

{{-- Liste des personnes ayants cotisee et statut invitation envoye --}}
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="text-center text-uppercase"> Personnes ayant payer leur cotisation </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th>Menbre</th>
                            <th>Date paiement</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>+</td>
                                <td>-</td>
                            </tr>
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
