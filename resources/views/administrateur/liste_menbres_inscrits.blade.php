
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
                            Utilisateurs Inscrits ( {{sizeof($liste_menbres_inscrits)}}  )
                            @if($filtre!=null)
                                <span class='text-uppercase'> [ Filtre : {{$filtre}} ] </span> <small><b><a class='text-danger' href='{{route('admin.liste_menbres_inscrits')}}'>x</a></b> </small> 
                            @endif
                        </h3>
                    <hr/>

                </div>
                <br/><br/>
                <div class="row">
                    <div class="table-responsive">
                        <table width="100%" class="table text-left" border="1" id="datatable">
                            <thead class="text-left">
                                <th>#(ordre inscription)</th>
                                <th>Membre</th>
                                <th>Contact</th>
                                <th>Devise</th>
                                <th>Etat</th>
                                <th>#</th>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                            @foreach($liste_menbres_inscrits as $item_menbre)
                                <tr>
                                    <td class="text-center">#{{$i++}}</td>
                                    <td> 
                                        Nom complet : <b>{{$item_menbre->nom_complet}}</b>  <br/>
                                        pays-ville : {{$item_menbre->pays}}, {{$item_menbre->ville}}  <br/>
                                        Etat USA : {{$item_menbre->etat_us}}  <br/>
                                        Adresse : {{$item_menbre->adresse}}  <br/>
                                    </td>
                                    <td>
                                       Tel :  {{$item_menbre->telephone}} <br/>
                                       Email :  {{$item_menbre->email}} <br/>
                                     </td>
                                     <td>
                                         @if($item_menbre->devise_choisie != null)
                                            {{$item_menbre->devise_choisie->code}} ({{$item_menbre->devise_choisie->monaie}}) 
                                        @else
                                          -
                                        @endif    
                                        <br/>
                                     </td>
                                    <td>
                                        <h3>
                                            <span class="badge badge-{{$item_menbre->etat =='suspendu' || $item_menbre->etat =='banni' ? 'danger' : 'success'}}">{{$item_menbre->etat}}</span>
                                        </h3>
                                    </td>
                                    <td>
                                        <button type="button" onclick="deplier_garde_fou('garde_fou_menbre_{{$item_menbre['id']}}')">Intervenir</button>
                                        <div class="col-12 garde_fou" id="garde_fou_menbre_{{$item_menbre['id']}}">

                                            <form method="post" action="{{route('admin.suspendre_menbre',[$item_menbre['id']])}}">
                                                <br/>
                                                <h6>Etat du compte utilisateur</h6>
                                                <br/>
                                                <select class="form-control" required name="nouvel_etat">
                                                    <option selected value="{{$item_menbre->etat}}" >{{$item_menbre->etat}}</option>
                                                    <option value="actif">actif</option>
                                                    <option value="suspendu">suspendu</option>
                                                    <option value="banni">banni</option>
                                                </select>
                                                <br/>
                                                <h6>Motif</h6>
                                                <br/>
                                                <textarea name="motif_intervention" class="form-control" placeholder="Entrer le motif de votre intervention" rows="4">{{$item_menbre->motif_intervention_admin}}</textarea>
                                                <br/>
                                                @method('put')
                                                @csrf
                                                <button type="submit" class="btn btn-danger"> Appliquer les modifications</button>
                                            </form>
                                        </div>
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
