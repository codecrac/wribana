@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Confirmer votre numero de telephone</h4>
                    <p class="card-description">
                        Nous allons vous envoyer un code de confirmation par sms, utiliser un numero valide,
                        ajouter le prefix avant le numero. Exemple : 2250505050505
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Utiliser ce numero</label>
                            <div class="row">
                                <div class="col-9">
                                    <input required type="tel" class="form-control" name="telephone"
                                           value="{{$le_menbre->telephone}}" minlength="10" placeholder="2250101010101">
                                </div>
                            </div>
                        </div>
                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Envoyer le message</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
