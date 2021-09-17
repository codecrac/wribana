
@extends('administrateur.base_administrateur')
@section('style_completmentaire')
    <style>
        .tr_bordered{
            border: 1px solid gray !important;
        }

        .clignote {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
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
                        Mes Waricrowds ( {{sizeof($liste_waricrowd)}} )
                    </h3>
                    <hr/>

                </div>
                <br/><br/>
                <div class="row">
                    <div class="table-responsive">
                        <table width="100%" class="table dataTable" border="1">
                            <thead class="text-center">
                            <th class="tr_bordered">Titre</th>
                            <th class="tr_bordered">Montant Objectif</th>
                            <th class="tr_bordered">Progression Financement</th>
                            <th class="tr_bordered">Statut</th>
                            <th class="tr_bordered">#</th>
                            </thead>
                            <tbody>
                            @foreach($liste_waricrowd as $item)
                                <tr class="tr_bordered text-center">
                                    <td class="tr_bordered">{{$item['titre']}}</td>
                                    <td class="tr_bordered"> {{number_format($item['montant_objectif'],0,',',' ')}} F </td>
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
                                        @php
                                            if($item->etat == 'valider'){
                                                $couleur= "success";
                                            }elseif($item->etat == 'recaler'){
                                                $couleur = "danger";
                                            }else{
                                                $couleur = "dark";
                                            }
                                        @endphp
                                        <b class="badge badge-{{$couleur}}">
                                            {{$item->etat}}
                                        </b>
                                    </td>

                                    <td class="tr_bordered" style="padding: 8px">
                                        <a href="{{route('admin.details_waricrowd',[$item['id']])}}" class="btn btn-primary">Details</a>
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
