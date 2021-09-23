@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
    $id_menbre_connecter = $la_session['id'];
    $nom_complet_menbre = $la_session['nom_complet'];
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>

        .conteneur_de_message{
            display: block;
            clear: both;
        }
        #div_all_message{
            background-color: white;
            height: 400px;
            padding: 10px;
        }
        .un_message{
            float: left;
            margin: 5px;
            padding: 10px;
            background-color: orange;
            border-radius: 5px;
        }

        .mon_message{
            float: right;
            margin: 5px;
            margin-left: 30px;
            padding: 10px;
            background-color: darkseagreen;
            border-radius: 5px;
        }
        .un_message > .auteur{
            font-size: 12px;
        }
    </style>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="card-title text-center text-uppercase"> Espace Chat tontine : {{$la_tontine->titre}}</h4>
                    <hr/>
                    {!! Session::get('notification','') !!}
                </div>
                <div class="card-body" style="background-color: orangered">
                    <div id="div_all_message">
                        <div class="conteneur_de_message">
                            <div class="un_message">
                                <span class="auteur"> <b>nom complet</b> <small>a écrit :</small> </span>
                                <h6>Un message de batard</h6>
                            </div>
                        </div>
                        <div class="conteneur_de_message">
                            <div class="mon_message">
                                <span class="auteur"> <b>nom complet</b> <small>a écrit :</small> </span>
                                <h6>Un message de batard</h6>
                            </div>
                        </div>
                    </div>
                    <form class="forms-sample" method="post" id="formulaire_envoi_message">
                            <div class="form-group">
                                <textarea class="form-control" rows="4" id="message" placeholder="Taper votre message ici"></textarea>
                            </div>
                            <h3 class="text-center">
                                @csrf
                                <input type="hidden" id="id_tontine" value="{{$la_tontine->id}}" required>
                                <input type="hidden" id="id_menbre_connecter" value="{{$id_menbre_connecter}}" required>
                                <button type="submit" id="btn_envoyer_le_message" class="btn btn-success mr-2">Envoyer</button>
                            </h3>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            @php $menbres = $la_tontine->participants; @endphp
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="text-center"> Menbres ({{sizeof($menbres)}}) </h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <th>Menbre</th>
                            <th>En ligne</th>
                        </thead>
                        <tbody>
                            @foreach($menbres as $item_menbre)
                                <tr>
                                    <td>{{$item_menbre['nom_complet']}}</td>
                                    <td>(Il y a 938239 minutes)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script_completmentaire')
    <script src="./../../js/app.js"></script>
@endsection
