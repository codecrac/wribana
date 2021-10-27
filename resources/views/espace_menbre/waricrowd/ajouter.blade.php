@php
    $la_session = session(\App\Http\Controllers\MenbreController::$cle_session);
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('content')
    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Créer un Waricrowd </h4>
                    <p class="card-description">
                        Je lance une collecte de fonds pour réaliser mon projet
                    </p>
                    <form class="forms-sample" 
                        method="post" action="{{route('espace_menbre.post_creer_un_waricrowd')}}" 
                        enctype="multipart/form-data"
                        id="formulaire_creation_crowd" >
                        <div class="form-group">
                            <label for="exampleInputUsername1">Catégories</label>
                            <select required class="form-control" id="input_categorie" name="id_categorie_waricrowd">
                                <option value>(selectionner)</option>
                                @foreach($liste_categorie_waricrowd as $item_categorie)
                                    <option value="{{$item_categorie['id']}}">{{$item_categorie['titre']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre *</label>
                            <input required type="text" id="input_titre" class="form-control" name="titre" placeholder="waricrowd Elegant">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Objectif de financement (Montant)  en <b>{{$la_session['devise']}}</b> *</label>
                            <input required type="number" id="input_objectif" class="form-control" name="montant_objectif" placeholder="1500000">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Pitch Video</label>
                            <input type="text" class="form-control" id="input_lien_pitch" name="lien_pitch_video" placeholder="https://www.youtube.com/watch?v=7nhRrU2eTF0&list=TLPQMjAwOTIwMjEgwbnpj96AXQ&index=10">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description courte *</label>
                            <textarea class="form-control" id="input_desc_courte" required name="description_courte" maxlength="220" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Description complète *</label>
                            <textarea class="form-control" required name="description_complete"  rows="20" cols="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Image d'illustration</label>
                            <input  type="file" class="form-control" name="image_illustration">
                        </div>

                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2" 
                                id="btn_soumettre_creation_crowd"
                                >Soumettre le projet</button>

                            {{-- <button type="button" onclick="resumer_modal()" 
                                class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter"
                                >Soumettre mon projet
                            </button> --}}
                        </h3>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4 text-center">
            <hr/>
                <h4>Comment ça marche</h4>
            <hr/>
            <iframe width="100%" src="https://www.youtube.com/embed/DzH5aRoMYLw" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>


    {{-- MODAL RESUME --}}
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">RESUME DU WARICROWD</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <hr/> 
                <div class="row">
                    <div class="col-4">
                        <h5> Categorie :  </h5>
                    </div>
                    <div class="col-8">
                        <h5 id="modal_categorie">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-4">
                        <h5> Titre :  </h5>
                    </div>
                    <div class="col-8">
                        <h5 id="modal_titre">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-4">
                        <h5> Objectif de financement :  </h5>
                    </div>
                    <div class="col-8">
                        <h5 id="modal_objectif_financement">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-4">
                        <h5> Lien pitch video :  </h5>
                    </div>
                    <div class="col-8">
                        <h5 id="modal_lien_pitch">   </h5>
                    </div>
                </div>
                <hr/> 
                <div class="row">
                    <div class="col-4">
                        <h5> Description courte :  </h5>
                    </div>
                    <div class="col-8">
                        <h5 id="modal_desc_crourte">   </h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="soumettre_le_formulaire()">Continuer et creer</button>
            </div>
          </div>
        </div>
    </div>

@endsection

@section('script_completmentaire')
    <script>
        function resumer_modal(){
            let categorie = document.getElementById('input_categorie');
            document.getElementById('modal_categorie').innerHTML = categorie.options[categorie.selectedIndex].text;
            document.getElementById('modal_titre').innerHTML = document.getElementById('input_titre').value;
            document.getElementById('modal_objectif_financement').innerHTML = document.getElementById('input_objectif').value;
            document.getElementById('modal_lien_pitch').innerHTML = document.getElementById('input_lien_pitch').value;
            document.getElementById('modal_desc_crourte').innerHTML = document.getElementById('input_desc_courte').value;
        }

        function soumettre_le_formulaire(){
            document.getElementById("btn_soumettre_creation_crowd").click();
        }
        
    </script>
@endsection
