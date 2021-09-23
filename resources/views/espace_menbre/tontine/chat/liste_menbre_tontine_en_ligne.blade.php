
    @php $menbres = $la_tontine->participants; @endphp
    <div class="card">
        <div class="card-header">
            <hr/>
            <h4 class="text-center"> Menbres ({{sizeof($menbres)}}/{{$la_tontine->nombre_participant}}) </h4>
            <hr/>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                <th>Menbre</th>
                <th>En ligne</th>
                </thead>
                <tbody>
                @foreach($menbres as $item_menbre)
                    <tr>
                        <td>{{$item_menbre['nom_complet']}}</td>
                        <td> ({{ \Carbon\Carbon::parse($item_menbre->date_derniere_visite)->diffForhumans() }})</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

