<?php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
?>


@extends('espace_menbre.base_espace_menbre')


@section('content')

    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="card-title text-center">TRANSFERT WARIBANK</h4>
                    <hr/>
                </div>
                <div class="card-body text-left text-uppercase">
                    {!! Session::get('notification','') !!}
                    <hr/>
                        <h5>TELEPHONE : {{ $numero_complet }}</h5>
                    <hr/>
                    <hr/>
                        <h5>DESTINATAIRE : {{ $le_destinataire->nom_complet }}</h5>
                    <hr/>
                    <hr/>
                        <h5>MONTANT (monaie expediteur) : {{ $montant_en_monaie_expediteur }} {{ $le_menbre->devise_choisie->monaie }} </h5>
                    <hr/>
                    <hr/>
                        <h5>MONTANT EQUIVALENT (monaie destinataire) : {{ $le_montant_equivalent_pour_destinataire }} {{$le_destinataire->devise_choisie->monaie}}</h5>
                    <hr/>
                        

                    <form method="post" action="{{route('espace_menbre.effectuer_tranfert_waribank')}}">
                        <input type="text" value="{{$numero_complet}}" name="numero_destinataire">
                        <input type="text" value="{{$le_destinataire->id}}" name="id_destinataire">
                        <input type="text" value="{{$montant_en_monaie_expediteur}}" name="montant_expediteur">
                        <input type="text" value="{{$le_montant_equivalent_pour_destinataire}}" name="montant_destinataire">

                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary" style="">Confirmer</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <hr/>
            <h4>Comment ça marche</h4>
            <hr/>
            <iframe width="100%" src="https://www.youtube.com/embed/DzH5aRoMYLw" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>
        </div>
    </div>

@endsection
