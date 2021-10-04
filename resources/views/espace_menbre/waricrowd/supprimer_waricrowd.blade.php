@extends('espace_menbre.base_espace_menbre')

@section('content')

    <div class="row">
        <div class="offset-md-3 col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {!! Session::get('notification','') !!}

                    <h4 class="card-title text-center">Supprimer le waricrowd</h4>
                    <p class="card-description">
                        <span class="text-danger">Cette action est irreversible, Voulez vous confirmez la suppression ?</span>

                    </p>
                    <form class="forms-sample" method="post" action="{{route('espace_menbre.post_supprimer_waricrowd',[$le_crowd->id])}}">
                            <h3 class="text-center">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger mr-2">Supprimer le waricrowd</button>
                            </h3>
                    </form>
                    <a class="btn btn-primary" href="{{route('espace_menbre.details_waricrowd',[$le_crowd->id])}}">RETOUR</a>
                </div>
            </div>
        </div>
    </div>

@endsection
