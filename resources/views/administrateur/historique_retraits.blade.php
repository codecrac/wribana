
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
      <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-header text-uppercase text-center">
                                <hr/>
                                    historique retraits des membres ( {{sizeof($historique_retraits)}} )
                                <hr/>
                                <br/>
                                <form method="get">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h5>Afficher les transactions</h5>
                                            @if($date_debut!=null)
                                                <a href="{{route('admin.historique_versements')}}" class="btn btn-danger">x</a>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            <h5>du</h5>
                                            <input class="form-control" value="{{$date_debut}}" name="date_debut" type="datetime-local">
                                        </div>
                                        <div class="col-md-3">
                                            <h5>au</h5>
                                            <input class="form-control" name="date_fin" type="datetime-local" value="{{$date_fin}}">
                                        </div>
                                        <div class="col-md-3">
                                            <h5>&nbsp;</h5>
                                            <button type="submit" class="btn btn-success">Ok</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-body">
                               <table class="table table-bordered table-striped">
                                    <thead>
                                        <th>Date</th>
                                        <th>Membre</th>
                                        <th>Solde Avant</th>
                                        <th>Montant Retiré</th>
                                        <th>Solde Après </th>
                                    </thead>
                                    <tbody>
                                        @foreach($historique_retraits as $item_retrait)
                                            <tr>
                                                <td>{{date("d/m/Y H:m",strtotime($item_retrait['created_at']))}}</td>
                                                <td>{{$item_retrait->menbre->nom_complet}}</td>
                                                <td>{{number_format($item_retrait->solde_avant,0,',',' ')}} {{$item_retrait->menbre->devise_choisie->monaie}}</td>
                                                <td>{{number_format($item_retrait->montant_retirer,0,',',' ')}} {{$item_retrait->menbre->devise_choisie->monaie}}</td>
                                                <td>{{number_format($item_retrait->solde_apres,0,',',' ')}} {{$item_retrait->menbre->devise_choisie->monaie}}</td>
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

    $resultat = "chaque $frequence_en_jour jours";
        if($frequence_en_jour >= 7){
            if($frequence_en_jour%7 ==0){
                $nb_semaines = $frequence_en_jour/7;
                $resultat = "chaque $nb_semaines semaines";
            }
        }
        return $resultat;
    }
@endphp
