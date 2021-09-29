@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
    $id_menbre_connecter = $la_session['id'];
    $nom_complet_menbre = $la_session['nom_complet'];
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>
        html{
            scroll-behavior: smooth;
        }
        #div_all_message{
            background-color: white;
            height: 400px;
            padding: 10px;
            overflow-y: scroll;
            clear: both;
        }
        .conteneur_de_message{
            display: block;
            clear: both;
        }
        .un_message{
            float: left;
            margin: 5px;
            padding: 10px;
            background-color: orange;
            border-radius: 5px;
            min-width: 200px;
        }

        .mon_message{
            float: right;
            text-align: right;
            margin: 5px;
            margin-left: 30px;
            padding: 10px;
            background-color: darkseagreen;
            border-radius: 5px;
            min-width: 200px;
        }
        .auteur{
            font-size: 12px;
            text-align: left !important;
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
                    <div id="div_all_message">
{{--                        @for($i=0;$i<15;$i++)--}}
                            @foreach($les_anciens_message as $item_message)
                                <div class="conteneur_de_message">
                                    <div class="{{($item_message->id_menbre == $id_menbre_connecter) ? 'mon_message' :'un_message'}}">
                                        <div class="auteur"> <b>{{$item_message->menbre_expediteur->nom_complet}}</b> <small>a écrit :</small> </div>
                                        <h6>{{$item_message->message}}</h6>
                                        <small>{{date('d-m-Y H:i',strtotime($item_message->created_at))}}</small>
                                    </div>
                                </div>
                            @endforeach
{{--                        @endfor--}}
                    </div>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="get" action="#" id="formulaire_envoi_message">
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
        <div class="col-md-5" id="qui_est_en_ligne">
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
                                    <td> ({{ \Carbon\Carbon::parse($item_menbre->date_derniere_visite)->diffForhumans() }}) </td>
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
    <script>
        var div_all_message = document.getElementById("div_all_message");
        div_all_message.scrollTop = div_all_message.scrollHeight;
    </script>
    <script src="./../../js/app.js"></script>
@endsection
