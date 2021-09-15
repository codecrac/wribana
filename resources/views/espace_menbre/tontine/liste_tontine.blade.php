
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
                    Mes Tontines ( {{sizeof($mes_tontines)}} )
                    <a class="btn btn-success" href="{{route('espace_menbre.ajouter_tontine')}}">Creer une tontine</a>
                </h3>
                <hr/>

            </div>
            <br/><br/>
            <div class="row">
                <div class="table-responsive">
                    <table width="100%" class="table" border="1">
                        <thead class="text-center">
                        <th class="tr_bordered">Titre</th>
                        <th class="tr_bordered">Nombres de participants</th>
                        <th class="tr_bordered">Montant à cotiser</th>
                        <th class="tr_bordered">Frequence de cotisation</th>
                        <th class="tr_bordered">Tour de</th>
                        <th class="tr_bordered">Creer par</th>
                        <th class="tr_bordered">#</th>
                        </thead>
                        <tbody>
                        @foreach($mes_tontines as $ma_tontine)
                            <tr class="tr_bordered text-center">
                                <td class="tr_bordered">{{$ma_tontine['titre']}}</td>
                                <td class="tr_bordered">{{sizeof($ma_tontine->participants)}}/{{$ma_tontine['nombre_participant']}}</td>
                                <td class="tr_bordered">{{number_format($ma_tontine['montant'],0,',',' ')}}F</td>
                                <td class="tr_bordered">{{formater_frequence($ma_tontine['frequence_depot_en_jours'])}}</td>
                                <td class="tr_bordered text-danger">Tour de</td>
                                <td class="tr_bordered">
                                    {{$ma_tontine->createur->nom_complet}}
                                </td>
                                <td class="tr_bordered" style="padding: 8px">

                                    <a href="{{route('espace_menbre.details_tontine',[$ma_tontine['id']])}}" class="btn btn-primary">Details</a>
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


@php
    function formater_frequence($frequence_en_jour){

    $resultat = "$frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7 ==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "$nb_semaines semaines";
            }
        }
        return $resultat;
    }
@endphp
