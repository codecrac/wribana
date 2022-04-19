<html>
    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <title>NON AUTORISE</title>
    </head>
    <body>
        <div class="jumbotron text-center alert-danger" style="margin:10%">
          <h1 class="display-3">Non autorisé !</h1>
          <p class="lead"><strong>Vous compte est suspendu.</p>
          <hr>
          <p class="lead">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <h3 class='text-center'>
                    <button class="btn btn-primary btn-sm" type="submit" style="padding:5px;background-color:#4ad">OK</button>
                </h3>
            </form>
          </p>
        </div>
    </body>
</html>


<?php /**PATH /home1/waribana/public_html/resources/views/administrateur/compte_suspendu.blade.php ENDPATH**/ ?>