@php
    $have_transactions = $le_crowd->transactions;
    if($have_transactions!=null){
      $have_transactions =true;
    }else{
        $have_transactions = false;
    }
@endphp

@extends('espace_menbre.base_espace_menbre')

@section('content')


    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-primary" href="{{route('espace_menbre.details_waricrowd',[$le_crowd->id])}}">RETOUR</a>
                </div>
                <div class="card-body">
                    {!! Session::get('notification','') !!}
                    <h4 class="card-title text-center">Editer un waricrowd</h4>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_editer_crowd',[$le_crowd->id])}}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Categories</label>
                            <select required class="form-control" name="id_categorie_waricrowd">
                                <option value="{{$le_crowd->id_categorie}}">{{$le_crowd->categorie->titre}}</option>
                                @foreach($liste_categorie_waricrowd as $item_categorie)
                                    <option value="{{$item_categorie['id']}}">{{$item_categorie['titre']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style="display: {{$have_transactions ? 'none' : ''}}">>
                            <label for="exampleInputUsername1">Titre *</label>
                            <input required type="text" class="form-control" name="titre" value="{{$le_crowd->titre}}" placeholder="Tontine Elegante">
                        </div>


                        <div class="form-group" style="display: {{$have_transactions ? 'none' : ''}}">
                            <label for="exampleInputUsername1">Objectif de financement (Montant) *</label>
                            <input required type="number" class="form-control" name="montant_objectif"
                                   value="{{$le_crowd->montant_objectif}}" placeholder="Tontine Elegante"
                                    {{$have_transactions ? 'readonly' : ''}}
                            >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Pitch Video</label>
                            <input type="text" class="form-control" name="lien_pitch_video" value="{{$le_crowd->lien_pitch_video}}" placeholder="Tontine Elegante">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description courte *</label>
                            <textarea class="form-control" name="description_courte" maxlength="220" rows="5">{{$le_crowd->description_courte}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description complete *</label>
                            <textarea class="form-control" name="description_complete"  rows="20" cols="5">{{$le_crowd->description_complete}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Selection pour changer l'image d'illustration</label>
                            <br/>
                            @if($le_crowd['image_illustration']!=null)
                                <img src="{{url($le_crowd->image_illustration)}}" style="max-width: 200px" />
                            @endif
                            <br/>
                            <input  type="file" class="form-control" name="image_illustration">
                        </div>

                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Soumettre mon projet</button>
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

@endsection
