<?php
require_once('../../controllers/LanguageController.php');

$controller = new LanguageController();

if (isset($_GET['id'])) {
    $idLanguage = $_GET['id'];
    $nameLanguage = '';
    $ISOcodeLanguage = '';
    $languageObject = $controller->getLanguageData($idLanguage, $nameLanguage, $ISOcodeLanguage);
} else {
    echo "ID IDIOMA NO ESPECIFICADO";
}
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
    <div class="container mt-5">
        <h1 class="mb-4">Editar idioma</h1>
        <div class="row">
            <div class="col-md-8">
                <form name="create_language" action="" method="POST">
                    <div class="mb-3">
                        <label for="languageName" class="form-label label-font-size">Nombre del idioma</label>
                        <input id="languageName" name="languageName" type="text" placeholder="Introduce el nombre del idioma" class="form-control" required value="<?php if (isset($languageObject)) echo $languageObject->getName(); ?>" />
                        <input type="hidden" name="languageId" value="<?php echo $idLanguage; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="languageISOcode" class="form-label label-font-size">ISO code del idioma</label>
                        <input id="languageISOcode" name="languageISOcode" type="text" placeholder="Introduce el ISO code del idioma" class="form-control" required value="<?php if (isset($languageObject)) echo $languageObject->getISOcode(); ?>" />
                        <input type="hidden" name="languageId" value="<?php echo $idLanguage; ?>" />
                    </div>
                    <input type="submit" value="Editar" class="btn btn-primary" name="editBtn" />
                </form>
            </div>
        </div>


        <?php
        $sendData = false;
        $languageEdited = false;
        $isoCodeError = false;

        if (isset($_POST['editBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['isoCodeError'])) {
        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger ms-2" role="alert">
                    El código ISO no puede tener mas de 5 caracteres.
                </div>
            </div>
        <?php
        }
        if (isset($_GET['isoError'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger ms-2" role="alert">
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
                    [$languageEdited, $isoError] = $controller->updateLanguage($_POST['languageId'], $_POST['languageName'], $_POST['languageISOcode']);
                }
            }
            if ($languageEdited) {
                header("Location: list.php?langEdited=" . $languageEdited);
            }
            if ($isoCodeError) {
                header("Location: edit.php?id=" . $idLanguage . "&isoCodeError=" . $isoCodeError);
            }
            if ($isoError) {
                header("Location: edit.php?id=" . $idLanguage . "&isoError=" . $isoError);
            } else {
            ?>
                <div class="row separation-up col-8">
                    <div class="alert alert-danger" role="alert">
                        El idioma no se ha editado correctamente.<br><a href="edit.php">Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }

        ?>
    </div>
</body>

</html>