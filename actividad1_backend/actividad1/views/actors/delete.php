<?php
require_once('../../controllers/ActorController.php');

$controller = new ActorController();


?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <title>Actividad 1</title>
</head>

<body>
    <?php


    $actorDeleted = false;

    if (isset($_POST['actorId'])) {
        $idActor = $_POST['actorId'];
        $actor = new Actor($idActor, '', '', '', '');
        $actor->setController($controller);
        $actorDeleted = $controller->deleteActor($idActor);
    } else {
        echo "no obtengo actor id";
    }

    if ($actorDeleted) {
    ?>
        <div class="row mt-3 ms-3 col-8">
            <div class="alert alert-success" role="alert">
                Actor o actriz borrado correctamente.<br><a href="list.php">Volver al listado de actores y actrices</a>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="row mt-3 ms-3 col-8">
            <div class="alert alert-danger" role="alert">
                El actor o actriz no se ha borrado correctamente.<br><a href="list.php">Volver a intentarlo</a>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>