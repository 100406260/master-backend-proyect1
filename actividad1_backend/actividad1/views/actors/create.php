<?php
require_once('../../controllers/ActorController.php');

$controller = new ActorController();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-bRdGC6raRjnO2TQeUn8s7Ie7Gb9zGqbn4fOz9sDL/Qq2UefKCTA5F5bs56jT1Wyw" crossorigin="anonymous"></script>
    <title>Actividad 1</title>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="container-title">
                    <h1 class="title">Crear actor o actriz</h1>
                </div>
                <form name="create_actors" action="" method="POST">
                    <div class="mb-3">
                        <label for="actorName" class="form-label label-font-size">Nombre del actor o actriz </label>
                        <input id="actorName" name="actorName" type="text" placeholder="Introduce el nombre del actor o actriz" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="actorSurname" class="form-label label-font-size">Apellidos del actor o actriz </label>
                        <input id="actorSurname" name="actorSurname" type="text" placeholder="Introduce los apellidos del actor o actriz" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="actorBirthdate" class="form-label label-font-size">Fecha de nacimiento del actor o actriz </label>
                        <input id="actorBirthdate" name="actorBirthdate" type="date" placeholder="Introduce la fecha de nacimiento del actor o actriz" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="actorNationality" class="form-label label-font-size">Nacionalidad del actor o actriz </label>
                        <input id="actorNationality" name="actorNationality" type="text" placeholder="Introduce la nacionalidad del actor o actriz" class="form-control" required />
                    </div>
                    <input type="submit" value="Crear" class="btn btn-primary" name="createBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $actorCreated = false;

        if (isset($_POST['createBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['actorRepeated'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger" role="alert">
                    El nombre y apellido del actor tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if ((isset($_POST['actorName'])) and (isset($_POST['actorSurname'])) and (isset($_POST['actorBirthdate'])) and (isset($_POST['actorNationality']))) {
                [$actorCreated, $actorRepeated] = $controller->createActors($_POST['actorName'], $_POST['actorSurname'], $_POST['actorBirthdate'], $_POST['actorNationality']);
            }
            if ($actorCreated) {
                header("Location: list.php?actorCreated=" . $actorCreated);
            }
            if ($actorRepeated) {
                header("Location: create.php?actorRepeated=" . $actorRepeated);
            } else {
            ?>
                <div class="row separation-up col-md-6">
                    <div class="alert alert-danger" role="alert">
                        El actor o actriz no se ha creado correctamente. <br><a href="create.php"> Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>
</body>

</html>