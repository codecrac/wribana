@extends('espace_menbre.base_espace_menbre')


@section('content')

    <div class="row">
        <div class=" col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Lancer un waricrowd</h4>
                    <p class="card-description">
                        Lancer une collecte de fond pour realiser mon projet
                    </p>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_creer_un_waricrowd')}}" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Categories</label>
                            <select required class="form-control" name="id_categorie_waricrowd">
                                <option value>(selectionner)</option>
                                @foreach($liste_categorie_waricrowd as $item_categorie)
                                    <option value="{{$item_categorie['id']}}">{{$item_categorie['titre']}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre *</label>
                            <input required type="text" class="form-control" name="titre" placeholder="waricrowd Elegant">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Objectif de financement (Montant) *</label>
                            <input required type="number" class="form-control" name="montant_objectif" placeholder="1500000">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Pitch Video</label>
                            <input type="text" class="form-control" name="lien_pitch_video" placeholder="https://www.youtube.com/watch?v=7nhRrU2eTF0&list=TLPQMjAwOTIwMjEgwbnpj96AXQ&index=10">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description courte *</label>
                            <textarea class="form-control" required name="description_courte" maxlength="220" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">description complete *</label>
                            <textarea class="form-control" required name="description_complete"  rows="20" cols="5"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputUsername1">Image d'illustration</label>
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
