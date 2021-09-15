@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Creer une tontine</h4>
                    <p class="card-description">
                        Creer votre tontine et invitez vos amis a y participer.
                    </p>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_ajouter_tontine')}}">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre</label>
                            <input required type="text" class="form-control" name="titre" placeholder="Tontine Elegante">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre de particpant</label>
                            <input required type="number" min="2" class="form-control" name="nombre_participant" placeholder="14">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Montant ( montant par personne ) </label>
                            <input required type="number" min="500" class="form-control" name="montant" placeholder="17500">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputConfirmPassword1">Frequence de depot (en jours)</label>
                            <input required type="number" min="1" class="form-control" name="frequence_depot_en_jours" placeholder="7">
                        </div>
                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Creer la tontine</button>
                        </h3>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
