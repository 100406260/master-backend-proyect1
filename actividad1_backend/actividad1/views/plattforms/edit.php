<?php
require_once('../../controllers/PlatformController.php');

$controller = new PlatformController();

if (isset($_GET['id'])) {
    $idPlatform = $_GET['id'];
    $namePlatform = '';
    $platformObject = $controller->getPlatformData($idPlatform, $namePlatform);
} else {
    echo "ID PLATFORM NO ESPECIFICADO";
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Actividad 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN7Jq16YDQt5u7T2kIVCpFUEfK6lZKexax" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Editar plataforma</h1>
        <div class="row">
            <div class="col-md-8">
                <form name="create_platform" action="" method="POST">
                    <div class="mb-3">
                        <label for="platformName" class="form-label label-font-size">Nombre de la plataforma</label>
                        <input id="platformName" name="platformName" type="text" placeholder="Introduce el nombre de la plataforma" class="form-control" required value="<?php if (isset($platformObject)) echo $platformObject->getName(); ?>" />
                        <input type="hidden" name="platformId" value="<?php echo $idPlatform; ?>" />
                    </div>
                    <input type="submit" value="Editar" class="btn btn-primary" name="editBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $platformEdited = false;

        if (isset($_POST['editBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['nameRepeated'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger ms-2" role="alert">
                    El nombre de la plataforma tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if (isset($_POST['platformName'])) {
                [$platformEdited, $nameRepeated] = $controller->updatePlatform($_POST['platformId'], $_POST['platformName']);
            }
            if ($platformEdited) {
                header("Location: list.php?platformEdited=" . $platformEdited);
            }
            if ($nameRepeated) {
                header("Location: edit.php?id=" . $idPlatform . "&nameRepeated=" . $nameRepeated);
            } else {
            ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-danger ms-2" role="alert">
                        La plataforma no se ha editado correctamente.<br><a href="edit.php">Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }
        ?>

    </div>

</body>

</html>