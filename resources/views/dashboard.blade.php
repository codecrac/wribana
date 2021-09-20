@extends('administrateur.base_administrateur')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                    <div class="mr-md-3 mr-xl-5">
                        <h2>Bienvenue <small>{{Auth::user()->name}}.</small></h2>
                        {{--                        <p class="mb-md-0">Your analytics dashboard template.</p>--}}
                    </div>
                    <div class="d-flex">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body dashboard-tabs p-0">
                    <ul class="nav nav-tabs px-4" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#"
                               role="tab" aria-controls="overview" aria-selected="true">#</a>
                        </li>
                    </ul>
                    <div class="tab-content py-0 px-0">
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="d-flex flex-wrap justify-content-xl-between">
                                <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    {{--                                    <i class="mdi mdi-calendar-heart icon-lg mr-3 text-primary"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('admin.les_tontines')}}"> Tontines </a> </small>
                                        <div class="dropdown">
                                            <h5 class="mb-0 d-inline-block">{{$nombre_tontine}}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    {{--                                    <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('admin.les_waricrowds')}}"> Waricrowds </a> </small>
                                        <h5 class="mr-2 mb-0">{{$nombre_waricrowd}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    {{--                                    <i class="mdi mdi-download mr-3 icon-lg text-warning"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('admin.les_waricrowds',['attente'])}}"> Waricrowds en attente </a> </small>
                                        <h5 class="mr-2 mb-0">{{$nombre_waricrowd_attente}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                                    {{--                                    <i class="mdi mdi-eye mr-3 icon-lg text-success"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('admin.liste_menbres_inscrits')}}">Utilisateurs Inscrits</a></small>
                                        <h5 class="mr-2 mb-0">{{$nombre_menbre}}</h5>
                                    </div>
                                </div>
                                <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
{{--                                    <i class="mdi mdi-currency-usd mr-3 icon-lg text-danger"></i>--}}
                                    <div class="d-flex flex-column justify-content-around">
                                        <small class="mb-1 text-muted"> <a href="{{route('admin.liste_menbres_inscrits',['attente'])}}"> Utilisateur Banni.e.s </a> </small>
                                        <h5 class="mr-2 mb-0"> {{$nombre_menbre_banni}} </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <hr/>
                        <h4>STATISTIQUE DE FREQUENTATION</h4>
                    <hr/>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered text-center">
                        <thead>
                            <th>Periode</th>
                            <th>Visiteurs</th>
                        </thead>
                        <tbody>
                            @foreach($statistique_frequentation as $item)
                            <tr>
                                <td>{{$item['mois_annee']}}</td>
                                <td>{{$item['visiteur']}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <img src="/assets/images/logo-waribana.png" />
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script_completmentaire')
    <script>
        window.onload = function() {
            fermer_tous_les_garde_fou();
        };

        function deplier_garde_fou(id){
            var le_garde_fou = document.getElementById(id);
            if(le_garde_fou.style.display =='none'){
                le_garde_fou.style.display = '';
            }else{
                le_garde_fou.style.display = 'none';
            }

        }

        function fermer_tous_les_garde_fou(){
            var tous_les_garde_fou = document.querySelectorAll('.garde_fou');
            for(var i=0; i<tous_les_garde_fou.length; i++){
                tous_les_garde_fou[i].style.display = "none";
            }
        }
    </script>
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
