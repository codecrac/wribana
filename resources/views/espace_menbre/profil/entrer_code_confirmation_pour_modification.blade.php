@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
    $id_menbre = $la_session['id'];
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Entrer le Code </h4>
                    <p class="card-description">
                        Nous vous avons envoyer un code de confirmation par sms au <b>{{$le_numero}}</b>, patientez 30 secondes.
                        <br/>
                        <a href="{{route('espace_menbre.profil',[$id_menbre])}}">je ne l'ai pas reçu</a>
                    </p>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_entrer_code_confirmation_pour_modification')}}">
                        <label>Telephone : {{$le_numero}}</label>
                        <div class="form-group">
                            <label for="exampleInputUsername1">Entrer le code</label>
                            <div class="col-12">
                                <input required type="hidden" class="form-control" name="nouveau_telephone" value="{{$le_numero}}">
                                <input required type="tel" class="form-control" name="code" placeholder="7368">
                            </div>
                        </div>
                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Valider</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
