@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <a href="{{route('espace_menbre.details_tontine',[$la_tontine['id']])}}">RETOUR</a>
                    <h4 class="card-title text-center">Editer la tontine</h4>
                    <p class="card-description text-center badge-info text-white">
                        Vous ne pourrez plus changer les termes apres le debut des paiements
                    </p>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_editer_tontine',[$la_tontine['id']])}}">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre</label>
                            <input
                                required type="text" class="form-control" name="titre" value="{{$la_tontine['titre']}}"
                                placeholder="Tontine Elegante"
                                {{sizeof($la_tontine->transactions) >0 ? "readonly" :""}}
                            >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de particpant</label>
                            <input
                                required type="number"
                                class="form-control" min="2" name="nombre_participant" value="{{$la_tontine['nombre_participant']}}"
                                placeholder="14"
                                {{sizeof($la_tontine->transactions) >0 ? "readonly" :""}}
                            >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Montant ( montant par personne ) </label>
                            <input required type="number"
                                   class="form-control" name="montant" value="{{$la_tontine['montant']}}" placeholder="17500"
                                   {{sizeof($la_tontine->transactions) >0 ? "readonly" :""}}
                            >

                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword1">Frequence de depot (en jours)</label>
                            <input required min="1" type="number" class="form-control" name="frequence_depot_en_jours"
                                   value="{{$la_tontine['frequence_depot_en_jours']}}"
                                   placeholder="7"
                                    {{sizeof($la_tontine->transactions) >0 ? "readonly" :""}}
                            >
                        </div>
                        <h3 class="text-center">

                            @if(sizeof($la_tontine->transactions) <1)
                                @csrf
                                @method('put')
                                <button type="submit" class="btn btn-danger mr-2">Modifier la tontine</button>
                            @endif
                        </h3>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
