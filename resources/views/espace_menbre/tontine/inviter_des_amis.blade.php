@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-2 col-md-9 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Inviter des amis</h4>

                    <ul>
                        <li>Tontine : {{$la_tontine['titre']}}</li>
                        <li>Nombre de particpant maximum: {{$la_tontine['nombre_participant']}}</li>
                        <li>Montant de la cotisation: {{$la_tontine['montant']}} F</li>
                        <li>Creer par : {{$la_tontine->createur->nom_complet}}</li>
                    </ul>
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
                </div>
            </div>
        </div>
    </div>

@endsection
