@extends('administrateur.base_administrateur')


@section('content')

    <div class="row">
        <div class="offset-md-2 col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Definir le contenu des sms de notification</h4>
                    <p class="card-description">
                        Les valeur $code$ , $titre$... seront remplcer par leur valeur dans le sms, Ne pas modifier/retirer.
                    </p>
                    <form class="forms-sample" method="post" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="exampleInputUsername1"> Confirmation de compte</label>
                            <textarea class="form-control" name="confirmation_compte">{{$la_ligne_notification->confirmation_compte}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1"> Etat tontine </label>
                            <textarea class="form-control" name="etat_tontine">{{$la_ligne_notification->etat_tontine}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1"> Etat waricrowd</label>
                            <textarea class="form-control" name="etat_waricrowd">{{$la_ligne_notification->etat_waricowd}}</textarea>
                        </div>

                        <div class="form-group" >
                            <label for="exampleInputUsername1"> Retard de paiement </label>
                            <textarea class="form-control" name="retard_paiement" maxlength="220" rows="5">{{$la_ligne_notification->retard_paiement}}</textarea>
                        </div>


                        <div class="form-group" style="display: none">
                            <label for="exampleInputUsername1"> invitation recue</label>
                            <textarea class="form-control" name="invitation_recue" maxlength="220" rows="5">{{$la_ligne_notification->invitation_recue}}</textarea>
                        </div>


                        <div class="form-group" >
                            <label for="exampleInputUsername1"> Virement montant tontine </label>
                            <textarea class="form-control" name="virement_compte_menbre_qui_prend" maxlength="220" rows="5">{{$la_ligne_notification->virement_compte_menbre_qui_prend}}</textarea>
                        </div>

                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-danger mr-2">Enregistrer les modification</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
