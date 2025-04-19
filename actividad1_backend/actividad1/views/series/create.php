<?php
require_once('../../controllers/SerieController.php');

$serieController = new SerieController();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Actividad 1</title>
</head>

<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="container-title">
                    <h1 class="title">Crear una Serie</h1>
                </div>
                <form name="create_serie" action="" method="POST">
                    <div class="mb-3">
                        <label for="serieTitle" class="form-label label-font-size">Nombre de la Serie </label>
                        <input id="serieTitle" name="serieTitle" type="text" placeholder="Introduce el nombre de la serie" class="form-control" required />
                    </div>
                    <input type="submit" value="Continuar" class="btn btn-primary" name="createBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $serieCreated = false;

        if (isset($_POST['createBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['nameRepeated'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger" role="alert">
                    El nombre de la serie tiene que ser unico.
                </div>
            </div>
            <?php
        }

        if ($sendData) {
            if (isset($_POST['serieTitle'])) {
                [$serieCreated, $serieId, $nameRepeated] = $serieController->createSerie($_POST['serieTitle']);
            }

            if ($serieCreated) {
                header("Location: create2.php?id=" . $serieId . "&serieName=" . $_POST['serieTitle']);
                exit();
            }
            if ($nameRepeated) {
                header("Location: create.php?nameRepeated=" . $nameRepeated);
            } else {
            ?>
                <div class="row separation-up col-md-6">
                    <div class="alert alert-danger" role="alert">
                        La serie no se ha creado correctamente. <br><a href="create.php"> Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>