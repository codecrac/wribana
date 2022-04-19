@extends('administrateur.base_administrateur')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Creer une categorie de waricrowd</h4>
                    <p class="card-description">
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Titre</label>
                            <input required type="text" class="form-control" name="titre"
                                   placeholder="Categorie Elegante">
                        </div>
                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Creer la categorie</button>
                        </h3>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="offset-md-1 col-md-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Liste des categories de waricrowd</h4>
                    <p class="card-description">
                    </p>
                    <table class="table table-striped">
                        <thead>
                        <th>titre</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        @foreach($liste_categorie_waricrowd as $item)
                            <tr>
                                <td>
                                    {{$item->titre}}
                                </td>
                                <td>
                                    <button type="button"
                                            onclick="deplier_garde_fou('garde_fou_recues_{{$item['id']}}')"
                                            class="badge badge-info">Agir
                                    </button>
                                    <div class="row garde_fou" id="garde_fou_recues_{{$item['id']}}">
                                        <form class="forms-sample row" method="post"
                                              action="{{route('admin.modifier_categorie_waricrowd',[$item['id']])}}">
                                            <div class="form-group col-12">

                                                <h6 class="text-center" for="exampleInputUsername1">Modifer la
                                                    categorie</h6>
                                                <input required type="text" class="form-control" name="titre"
                                                       value="{{$item['titre']}}" placeholder="Categorie Elegante">
                                            </div>
                                            
                                            @if(auth()->user()->role == 'super_admin' )
                                                <div class="text-center col-12">
                                                    @method('put')
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning mr-2">OK</button>
                                                    <br/><br/>
                                                    <a href="{{route('admin.effacer_categorie_waricrowd',[$item->id])}}"
                                                       class="btn btn-danger">Supprimer</a>
                                                </div>
                                            @endif
                                        </form>
                                        <div>
                                        </div>
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

@endsection

@section('script_completmentaire')
    <script>
        window.onload = function () {
            fermer_tous_les_garde_fou();
        };

        function deplier_garde_fou(id) {
            var le_garde_fou = document.getElementById(id);
            if (le_garde_fou.style.display == 'none') {
                le_garde_fou.style.display = '';
            } else {
                le_garde_fou.style.display = 'none';
            }

        }

        function fermer_tous_les_garde_fou() {
            var tous_les_garde_fou = document.querySelectorAll('.garde_fou');
            for (var i = 0; i < tous_les_garde_fou.length; i++) {
                tous_les_garde_fou[i].style.display = "none";
            }
        }
    </script>
@endsection
