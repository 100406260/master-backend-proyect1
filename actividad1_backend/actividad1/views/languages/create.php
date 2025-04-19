<?php
require_once('../../controllers/LanguageController.php');

$controller = new LanguageController();

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
                    <h1 class="title">Crear idioma</h1>
                </div>
                <form name="create_languages" action="" method="POST">
                    <div class="mb-3">
                        <label for="languageName" class="form-label label-font-size">Nombre del idioma </label>
                        <input id="languageName" name="languageName" type="text" placeholder="Introduce el nombre del idioma" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="languageISOcode" class="form-label label-font-size">ISO code del idioma </label>
                        <input id="languageISOcode" name="languageISOcode" type="text" placeholder="Introduce el ISO code del idioma" class="form-control" required />
                    </div>
                    <input type="submit" value="Crear" class="btn btn-primary" name="createBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $languageCreated = false;
        $isoCodeError = false;

        if (isset($_POST['createBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['isoCodeError'])) {
        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger" role="alert">
                    El código ISO no puede tener mas de 5 caracteres.
                </div>
            </div>
        <?php
        }
        if (isset($_GET['isoError'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger" role="alert">
                    El código ISO Code tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if ((isset($_POST['languageName'])) and (isset($_POST['languageISOcode']))) {
                $languageISOcode = $_POST['languageISOcode'];

                // Validación del ISO Code en el lado del servidor
                if (strlen($languageISOcode) > 5) {
                    $isoCodeError = true; // Marcamos que hay un error con el ISO Code
                } else {
                    [$languageCreated, $isoError] = $controller->createLanguages($_POST['languageName'], $languageISOcode);
                }
            }
            if ($languageCreated) {
                header("Location: list.php?langCreated=" . $languageCreated);
            }
            if ($isoCodeError) {
                header("Location: create.php?isoCodeError=" . $isoCodeError);
            }
            if ($isoError) {
                header("Location: create.php?isoError=" . $isoError);
            } else {
            ?>
                <div class="row separation-up col-md-6">
                    <div class="alert alert-danger" role="alert">
                        El idioma no se ha creado correctamente. <br><a href="create.php"> Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>
</body>

</html>