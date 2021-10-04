
@extends('espace_menbre.base_espace_menbre')
@section('style_completmentaire')
    <style>
        .tr_bordered{
            border: 1px solid gray !important;
        }
    </style>
@endsection
@section('content')

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <hr/>
                    <h3 class="text-center">
                        Projets Soutenus ( {{sizeof($projets_soutenus)}} )
                        <a class="btn btn-success" href="{{route('espace_menbre.creer_un_waricrowd')}}">Creer un waricrowd</a>
                    </h3>
                    <hr/>

                </div>
                <br/><br/>
                <div class="row">
                    <div class="table-responsive">
                        <table width="100%" class="table" border="1">
                            <thead class="text-center">
                            <th class="tr_bordered">Titre</th>
                            <th class="tr_bordered">Montant Objectif</th>
                            <th class="tr_bordered">Progression Financement</th>
                            <th class="tr_bordered">Statut</th>
                            <th class="tr_bordered">#</th>
                            </thead>
                            <tbody>
                            @foreach($projets_soutenus as $item)
                                <tr class="tr_bordered text-center">
                                    <td class="tr_bordered">{{$item['titre']}}</td>
                                    <td class="tr_bordered"> {{number_format($item['montant_objectif'],0,',',' ')}}  <b>{{$item->createur->devise_choisie->monaie}}</b> </td>
                                    <td class="tr_bordered">
                                        @php
                                            $pourcentage = round($item->caisse->montant *100 / $item->caisse->montant_objectif,2);
                                            if($pourcentage <40){
                                                $couleur= "danger";
                                            }elseif($pourcentage <60){
                                                $couleur = "warning";
                                            }elseif($pourcentage <100){
                                                $couleur = "info";
                                            }else{
                                                $couleur = "success";
                                            }
                                        @endphp
                                        <span class="badge badge-{{$couleur}}">{{$pourcentage}} %</span>
                                    </td>
                                    <td class="tr_bordered text-danger">
                                        <b class="badge badge-{{($item->etat=='valider' ? 'success' : $item->etat=='recaler') ? 'danger' : "dark"}}">
                                            {{$item->etat}}
                                        </b>
                                    </td>

                                    <td class="tr_bordered" style="padding: 8px">
                                        <a href="{{route('espace_menbre.details_waricrowd',[$item['id']])}}" class="btn btn-primary">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
