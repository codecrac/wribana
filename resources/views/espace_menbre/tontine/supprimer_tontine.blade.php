@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Supprimer la tontine</h4>
                    <p class="card-description">
                        <span class="text-danger">Cette action est irreversible, Voulez vous confirmez la suppression ?</span>

                    </p>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_supprimer_tontine',[$la_tontine->id])}}">
                            <h3 class="text-center">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger mr-2">Supprimer la tontine</button>
                            </h3>
                        <a class="btn btn-primary" href="{{route('espace_menbre.details_tontine',[$la_tontine->id])}}">RETOUR</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
