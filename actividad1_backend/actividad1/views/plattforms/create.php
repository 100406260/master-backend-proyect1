<?php
require_once('../../controllers/PlatformController.php');

$controller = new PlatformController();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

    <title>Actividad 1</title>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-8">
                <div class="container-title">
                    <h1 class="title">Crear plataforma</h1>
                </div>
                <form name="create_platforms" action="" method="POST">
                    <div class="mb-3">
                        <label for="platformName" class="form-label label-font-size">Nombre plataforma </label>
                        <input id="platformName" name="platformName" type="text" placeholder="Introduce el nombre de la plataforma" class="form-control" required />
                    </div>
                    <input type="submit" value="Crear" class="btn btn-primary" name="craeteBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $platformCreated = false;

        if (isset($_POST['craeteBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['nameRepeated'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger" role="alert">
                    El nombre de la plataforma tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if (isset($_POST['platformName'])) {
                [$platformCreated, $nameRepeated] = $controller->createPlatforms($_POST['platformName']);
            }
            if ($platformCreated) {
                header("Location: list.php?platformCreated=" . $platformCreated);
            }
            if ($nameRepeated) {
                header("Location: create.php?nameRepeated=" . $nameRepeated);
            } else {

            ?>
                <div class="row separation-up col-md-8">
                    <div class="alert alert-danger" role="alert">
                        La plataforma no se ha creado correctamente. <br><a href="create.php"> Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>