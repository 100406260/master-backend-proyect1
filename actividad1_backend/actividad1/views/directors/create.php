<?php
require_once('../../controllers/DirectorController.php');

$controller = new DirectorController();

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
                    <h1 class="title">Crear director</h1>
                </div>
                <form name="create_directors" action="create.php" method="POST">
                    <div class="mb-3">
                        <label for="directorName" class="form-label label-font-size">Nombre del director </label>
                        <input id="directorName" name="directorName" type="text" placeholder="Introduce el nombre del director" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="directorSurname" class="form-label label-font-size">Apellidos del director </label>
                        <input id="directorSurname" name="directorSurname" type="text" placeholder="Introduce los apellidos del director" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="directorBirthdate" class="form-label label-font-size">Fecha de nacimiento del director </label>
                        <input id="directorBirthdate" name="directorBirthdate" type="date" placeholder="Introduce la fecha de nacimiento del director" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="directorNationality" class="form-label label-font-size">Nacionalidad del director </label>
                        <input id="directorNationality" name="directorNationality" type="text" placeholder="Introduce la nacionalidad del director" class="form-control" required />
                    </div>
                    <input type="submit" value="Crear" class="btn btn-primary" name="createBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $directorCreated = false;

        if (isset($_POST['createBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['directorRepeated'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger" role="alert">
                    El nombre y apellido del director tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if (isset($_POST['directorName']) && isset($_POST['directorSurname']) && isset($_POST['directorBirthdate']) && isset($_POST['directorNationality'])) {
                [$directorCreated, $directorRepeated] = $controller->createDirectors($_POST['directorName'], $_POST['directorSurname'], $_POST['directorBirthdate'], $_POST['directorNationality']);
            }
            if ($directorCreated) {
                header("Location: list.php?directorCreated=" . $directorCreated);
            }
            if ($directorRepeated) {
                header("Location: create.php?directorRepeated=" . $directorRepeated);
            } else {
            ?>
                <div class="row separation-up col-md-6">
                    <div class="alert alert-danger" role="alert">
                        El director no se ha creado correctamente. <br><a href="create.php"> Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>