<?php
  $statut_transaction = null;
    if(isset($_GET['statut_transaction'])){
        $statut_transaction = $_GET['statut_transaction'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Waribana</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
  

      <?php if($statut_transaction !=null && !isset($_GET['probleme_lien_paiement']) ): ?>
          <?php if($statut_transaction == 'ACCEPTED'): ?>
            <div class="jumbotron text-center">
              <h1 class="display-3 text-success">Succes !</h1>
              <div class='alert alert-success text-center'>Votre paiement a bien été effectué </div>
              <p class="lead"> Cliquez sur le bouton retour pour retourne a l'application</p>
              <hr>
            </div>
          <?php else: ?>
            <div class="jumbotron text-center">
              <h1 class="display-3 text-danger">Echec de paiement</h1>
              <div class='alert alert-danger text-center'>Votre paiement a echoué </div>
              <p class="lead"> Cliquez sur le bouton retour pour retourne a l'application</p>
              <hr>
            </div>
          <?php endif; ?>
      <?php endif; ?>


  <?php if(isset($_GET['probleme_lien_paiement'])): ?>
          
          <div class="jumbotron text-center">
            <h1 class="display-3 text-danger">Quelque chose s'est mal passé !</h1>
            
            <div class='alert alert-danger text-center'><?php echo e($_GET['probleme_lien_paiement']); ?></div>
            <p class="lead"> Cliquez sur le bouton retour pour retourné a l'application</p>
            <hr>
            
            
          </div>

  <?php endif; ?>
</body>
</html><?php /**PATH /home1/waribana/public_html/resources/views/api/statut_transaction.blade.php ENDPATH**/ ?>