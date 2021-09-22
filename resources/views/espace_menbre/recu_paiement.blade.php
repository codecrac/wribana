<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recu Waribana</title>
</head>
<body>
    <table width="100%" border="1">
        <tbody>
            <tr>
                <td class="text-left">
                    <div style="padding: 10px">
                        <img src="/assets/images/logo-waribana.png" width="80px" style="float: left">
                        <h3 style="float: right">Waribana</h3>
                    </div>
                </td>
            </tr>
            <tr>
                <td >
                    <h3 style="text-align: center; text-transform: uppercase"> Recu de paiement sur {{$infos_pour_recu['type_section']}} </h3>
                </td>
            </tr>


            <tr>
                <td>Date : <span style="text-transform: uppercase;font-weight: bold">{{date('d/m/Y H:i:s')}}</span> </td>
            </tr>
            <tr>
                <td>Paiement pour : <span style="text-transform: uppercase;font-weight: bold">{{$infos_pour_recu['titre_section']}}</span> </td>
            </tr>
            <tr>
                <td>Nom complet : <span style="text-transform: uppercase;font-weight: bold">Un gars</span> </td>
            </tr>
            <tr>
                <td>Montant : <span style="text-transform: uppercase;font-weight: bold">{{number_format('383634',0,',',' ')}} F</span> </td>
            </tr>

            @if($infos_pour_recu['type_section'])
                <tr>
                    <td>Tour de : <span style="text-transform: uppercase;font-weight: bold">{{$infos_pour_recu['nom_menbre_qui_prend']}}</span> </td>
                </tr>
            @endif


        </tbody>
    </table>
</body>
</html>
