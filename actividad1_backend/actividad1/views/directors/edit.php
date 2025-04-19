<?php
require_once('../../controllers/DirectorController.php');

$controller = new DirectorController();

if (isset($_GET['id'])) {
    $idDirector = $_GET['id'];
    $nameDirector = '';
    $surnameDirector = '';
    $birthdateDirector = '';
    $nationalityDirector = '';
    $directorObject = $controller->getDirectorData($idDirector, $nameDirector, $surnameDirector, $birthdateDirector, $nationalityDirector);
} else {
    echo "ID DIRECTOR NO ESPECIFICADO";
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
        <h1 class="mb-4">Editar director</h1>
        <div class="row">
            <div class="col-md-8">
                <form name="create_director" action="" method="POST">
                    <div class="mb-3">
                        <label for="directorName" class="form-label label-font-size">Nombre del director</label>
                        <input id="directorName" name="directorName" type="text" placeholder="Introduce el nombre del director" class="form-control" required value="<?php if (isset($directorObject)) echo $directorObject->getName(); ?>" />
                        <input type="hidden" name="directorId" value="<?php echo $idDirector; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="directorSurname" class="form-label label-font-size">Apellidos del director</label>
                        <input id="directorSurname" name="directorSurname" type="text" placeholder="Introduce los apellidos del director" class="form-control" required value="<?php if (isset($directorObject)) echo $directorObject->getSurname(); ?>" />
                        <input type="hidden" name="directorId" value="<?php echo $idDirector; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="directorBirthdate" class="form-label label-font-size">Fecha de nacimiento del director</label>
                        <input id="directorBirthdate" name="directorBirthdate" type="date" placeholder="Introduce la fecha de nacimiento del director" class="form-control" required value="<?php if (isset($directorObject)) echo $directorObject->getBirthdate(); ?>" />
                        <input type="hidden" name="directorId" value="<?php echo $idDirector; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="directorNationality" class="form-label label-font-size">Nacionalidad del director</label>
                        <input id="directorNationality" name="directorNationality" type="text" placeholder="Introduce la nacionalidad del director" class="form-control" required value="<?php if (isset($directorObject)) echo $directorObject->getNationality(); ?>" />
                        <input type="hidden" name="directorId" value="<?php echo $idDirector; ?>" />
                    </div>
                    <input type="submit" value="Editar" class="btn btn-primary" name="editBtn" />
                </form>
            </div>


            <?php
            $sendData = false;
            $directorEdited = false;

            if (isset($_POST['editBtn'])) {
                $sendData = true;
            }
            if (isset($_GET['directorRepeated'])) {

            ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-danger ms-2" role="alert">
                        El nombre y apellido del director tiene que ser unico.
                    </div>
                </div>
                <?php
            }
            if ($sendData) {
                if ((isset($_POST['directorName'])) and (isset($_POST['directorSurname'])) and (isset($_POST['directorBirthdate'])) and (isset($_POST['directorNationality']))) {
                    [$directorEdited, $directorRepeated] = $controller->updateDirector($_POST['directorId'], $_POST['directorName'], $_POST['directorSurname'], $_POST['directorBirthdate'], $_POST['directorNationality']);
                }
                if ($directorEdited) {
                    header("Location: list.php?directorEdited=" . $directorEdited);
                }
                if ($directorRepeated) {
                    header("Location: edit.php?id=" . $idDirector . "&directorRepeated=" . $directorRepeated);
                } else {
                ?>
                    <div class="row mt-3 col-8">
                        <div class="alert alert-danger ms-2" role="alert">
                            El director no se ha editado correctamente.<br><a href="edit.php">Volver a intentarlo.</a>
                        </div>
                    </div>
            <?php
                }
            }

            ?>
        </div>
</body>

</html>