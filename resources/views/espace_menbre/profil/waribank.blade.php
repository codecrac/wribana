@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp


@extends('espace_menbre.base_espace_menbre')

@section('style_completmentaire')
    <style>
        .marquer_presence{
            font-size: 18px;
            font-weight:bold;
        }
    </style>
@endsection

@section('content')
    {!! Session::get('notification','') !!}

    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center">Recharger mon compte</h4>
                    <hr/>
                </div>
                <div class="card-body">
                   
                    <form method="post" action="{{route('espace_menbre.rechargement_waribank')}}">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-dark">Entrer le montant *</label>
                                 <input type="number" name="montant_recharge" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="Entrer le montant" /> 
                            </div>
                            <div class="col-12 text-center">
                                <br/>
                                @csrf
                                <button class="btn btn-success" > Recharger </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center">Transfert a un autre compte waribank</h4>
                    <hr/>
                </div>
                
                <div class="card-body">
                   
                    <form method="post" action="{{route('espace_menbre.confirmer_waribank')}}">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-dark">Entrer le numero du destinataire *</label>
                                
                                <div class="col-12">
                                    <label class="text-info">Mot de passe actuel *</label>
                                    <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                    <br/>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="number" name="prefixe" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="prefixe" value="225" />
                                    </div>
                                    <div class="col-md-8">
                                        <input type="number" name="telephone" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="telephone" />
                                    </div>
                                </div>

                                <div class="col-12">
                                    <br/><br/>
                                    <input type="number" name="montant" required class="form-control" min="1" type="form-control" style="border: 1px solid black" placeholder="montant" />
                                </div>
                                 
                            </div>
                            <div class="col-12 text-center">
                                <br/>
                                @csrf
                                <button class="btn btn-success" > Transferer </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4 class="card-title text-center"> MON COMPTE</h4>
                    <hr/>
                </div>
                <div class="card-body text-center">
                    <h3>Solde : {{number_format($le_menbre->compte->solde,0,',',' ')}} {{$la_session['devise']}} <small style="font-size: 14px;text-decoration: underline"> <a href="#details">Details</a> </small> </h3>
                    <br/>
                    <hr/>
                        <h4 class="text-center">Retirer de l'argent</h4>
                    <hr/>
                    <form method="post" action="{{route('espace_menbre.confirmer_retrait_dargent')}}">
                        <div class="row">
                            <div class="col-12">
                                <label class="text-info">Mot de passe actuel *</label>
                                <input required class="form-control" value  type="password" name="mot_de_passe_actuel" style="border: 1px solid black" />
                                <br/>
                            </div>
                            <div class="col-12">
                                <label class="text-dark">Entrer le montant *</label>
                                 <input type="number" name="montant" required class="form-control" max='{{$le_menbre->compte->solde}}' type="form-control" style="border: 1px solid black" placeholder="Entrer le montant" /> 
                                <!--<input type="number" name="montant" required class="form-control" type="form-control" style="border: 1px solid black" placeholder="Entrer le montant" />-->
                            </div>
                            <div class="col-12 text-center">
                                <br/>
                                @csrf
                                <button class="btn btn-success" > Retirer </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    

    
    <div class="row" id="details">

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center text-uppercase"> Historique des rechargements  </h4>
                    <hr/>
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>Date</th>
                            <th>Solde avant</th>
                            <th>Montant</th>
                            <th>Solde apres</th>
                        </thead>
                        <tbody>
                            @foreach($le_menbre->historique_rechargement as $item_rechargement)
                                <tr>
                                    <td>{{date("d/m/Y H:m",strtotime($item_rechargement['created_at']))}}</td>
                                    <td>{{number_format($item_rechargement->solde_avant,0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                    <td>{{number_format($item_rechargement['montant'],0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                    <td>{{number_format($item_rechargement->solde_apres,0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center text-uppercase"> Historique des virements de tontine   </h4>
                    <hr/>
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>Date</th>
                            <th>Tontine</th>
                            <th>Montant</th>
                        </thead>
                        <tbody>
                            @foreach($le_menbre->historique_virement_tontine as $item_virement)
                                <tr>
                                    <td>{{date("d/m/Y H:m",strtotime($item_virement['created_at']))}}</td>
                                    <td>{{$item_virement->tontine->titre}}</td>
                                    <td>{{number_format($item_virement['montant'],0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="historie_retraits">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center text-uppercase"> Historique transfert recus   </h4>
                    <hr/>
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>Date</th>
                            <th>Expediteur</th>
                            <th>Montant <br/> (monaie expediteur) </th>
                            <th>Montant equivatent <br/> ( monaie destinataire) </th>
                            <th>Destinaire</th>
                        </thead>
                        <tbody>
                            @foreach($le_menbre->historique_transfert_entrant as $item_entrant)
                                <tr>
                                    <td>{{date("d/m/Y H:m",strtotime($item_entrant['created_at']))}}</td>
                                    <td>{{$item_entrant->expediteur->nom_complet}}</td>
                                    <td>{{number_format($item_entrant->montant_monaie_expediteur,0,',',' ')}} {{$item_entrant->expediteur->devise_choisie->monaie}}</td>
                                    <td>{{number_format($item_entrant->montant_equivalent_destinataire,0,',',' ')}} {{$item_entrant->destinataire->devise_choisie->monaie}}</td>
                                    <td>Vous</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row" id="historie_retraits">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center text-uppercase"> Historique transfert effectués </h4>
                    <hr/>
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>Date</th>
                            <th>Expediteur</th>
                            <th>Montant <br/> (monaie expediteur) </th>
                            <th>Montant <br/> ( monaie destinataire) </th>
                            <th>[ Telephone ]</th>
                            <th>Destinaire</th>
                        </thead>
                        <tbody>
                            @foreach($le_menbre->historique_tranfert_sortant as $item_sortant)
                                <tr>
                                    <td>{{date("d/m/Y H:m",strtotime($item_sortant['created_at']))}}</td>
                                    <td>Vous</td>
                                    <td>{{number_format($item_sortant->montant_monaie_expediteur,0,',',' ')}} {{$item_sortant->expediteur->devise_choisie->monaie}}</td>
                                    <td>{{number_format($item_sortant->montant_equivalent_destinataire,0,',',' ')}} {{$item_sortant->destinataire->devise_choisie->monaie}}</td>
                                    <td>{{$item_sortant->telephone}}</td>
                                    <td>{{$item_sortant->destinataire->nom_complet}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="historie_retraits">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <hr/>
                    <h4 class="card-title text-center text-uppercase"> Historique des mes retraits </h4>
                    <hr/>
                </div>
                <div class="card-body text-center">
                    <table class="table table-bordered table-striped datatable">
                        <thead>
                            <th>Date</th>
                            <th>Solde Avant</th>
                            <th>Montant Retiré</th>
                            <th>Solde Apres</th>
                        </thead>
                        <tbody>
                            @foreach($le_menbre->historique_retraits as $item_retrait)
                                <tr>
                                    <td>{{date("d/m/Y H:m",strtotime($item_retrait['created_at']))}}</td>
                                    <td>{{number_format($item_retrait->solde_avant,0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                    <td>{{number_format($item_retrait->montant,0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                    <td>{{number_format($item_retrait->solde_apres,0,',',' ')}} {{$le_menbre->devise_choisie->monaie}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaines";
            }
        }
        return $resultat;
    }
@endphp
