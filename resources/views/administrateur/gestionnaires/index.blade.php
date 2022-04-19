@extends('administrateur.base_administrateur')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">CREER UN GESTIONNAIRE</h4>
                    <p class="card-description">
                    </p>
                    <form class="forms-sample" method="post">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Type de gestionnaire</label>
                            <select required  class="form-control" name="role"
                                   placeholder="Categorie Elegante">
                                <option value='gestionnaire_de_tontine' >Gestionnaire de Tontine</option>
                                <option value='gestionnaire_de_waricrowd' >Gestionnaire de Waricrowd</option>
                                <option value='administrateur_general' >Administrateur General</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputUsername1">Nom complet</label>
                            <input required type="text" class="form-control" name="nom_complet"
                                   >
                        </div>
                        <br/>
                        
                        <div class="form-group">
                            <label for="exampleInputUsername1">Email</label>
                            <input required type="text" class="form-control" name="email"
                                   >
                        </div>
                        <p class="text-danger text-center" ><b>le mot de passe par defaut est : waribana</b> </p>
                        <br/>
                        <h3 class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-primary mr-2">Creer le gestionnaire</button>
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

                    <h4 class="card-title text-center text-uppercase">Liste des GESTIONNAIRES</h4>
                    <p class="card-description">
                    </p>
                    <table class="table table-striped">
                        <thead>
                        <th>Titre</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>#</th>
                        </thead>
                        <tbody>
                        @foreach($liste_gestionnaire as $item)
                            <tr>
                                <td>
                                    {{$item->name}}
                                </td>
                                <td>
                                    {{$item->email}}
                                </td>
                                <td>
                                    {{ str_replace('_',' ',$item->role) }}
                                </td>
                                <td>
                                    <button type="button"
                                            onclick="deplier_garde_fou('garde_fou_recues_{{$item['id']}}')"
                                            class="badge badge-info">Agir
                                    </button>
                                    <div class="row garde_fou" id="garde_fou_recues_{{$item['id']}}">
                                        <form class="forms-sample row" method="post"
                                              action="{{route('admin.modifier_gestionnaire',[$item['id']])}}">
                                            
                                            <div class="form-group col-12">
                                                <h6 class="text-center" for="exampleInputUsername1">Habilitation</h6>
                                                    <select class='form-control' name='role'>
                                                        <option value='{{$item->role}}' > {{ str_replace('_',' ',$item->role) }} </option>
                                                        
                                                        <option value='gestionnaire_de_tontine' >Gestionnaire de Tontine</option>
                                                        <option value='gestionnaire_de_waricrowd' >Gestionnaire de Waricrowd</option>
                                                        <option value='administrateur_general' >Administrateur General</option>
                                                    </select>
                                               
                                               <br/>
                                                <h6 class="text-center" for="exampleInputUsername1">Etat du compte</h6>
                                                
                                                    <select class='form-control' name='etat'>
                                                        <option value='{{$item->etat}}' > {{ str_replace('_',' ',$item->etat) }} </option>
                                                        
                                                        <option value='actif' >Actif</option>
                                                        <option value='suspendu' >Suspendu</option>
                                                    </select>
                                                
                                                <br/>
                                                @csrf
                                                @method('put')
                                                <button type="submit" class="btn btn-warning mr-2">Enregistrer</button>
                                                     
                                            </div>
                                            
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
