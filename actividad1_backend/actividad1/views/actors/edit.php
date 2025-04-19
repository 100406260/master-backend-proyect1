<?php
require_once('../../controllers/ActorController.php');

$controller = new ActorController();

if (isset($_GET['id'])) {
    $idActor = $_GET['id'];
    $nameActor = '';
    $surnameActor = '';
    $birthdateActor = '';
    $nationalityActor = '';
    $actorObject = $controller->getActorData($idActor, $nameActor, $surnameActor, $birthdateActor, $nationalityActor);
} else {
    echo "ID ACTOR NO ESPECIFICADO";
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
        <h1 class="mb-4">Editar actor/actriz</h1>
        <div class="row">
            <div class="col-md-8">
                <form name="create_actor" action="" method="POST">
                    <div class="mb-3">
                        <label for="actorName" class="form-label label-font-size">Nombre del actor o actriz</label>
                        <input id="actorName" name="actorName" type="text" placeholder="Introduce el nombre del actor o actriz" class="form-control" required value="<?php if (isset($actorObject)) echo $actorObject->getName(); ?>" />
                        <input type="hidden" name="actorId" value="<?php echo $idActor; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="actorSurname" class="form-label label-font-size">Apellidos del actor o actriz</label>
                        <input id="actorSurname" name="actorSurname" type="text" placeholder="Introduce los apellidos del actor o actriz" class="form-control" required value="<?php if (isset($actorObject)) echo $actorObject->getSurname(); ?>" />
                        <input type="hidden" name="actorId" value="<?php echo $idActor; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="actorBirthdate" class="form-label label-font-size">Fecha de nacimiento del actor o actriz</label>
                        <input id="actorBirthdate" name="actorBirthdate" type="date" placeholder="Introduce la fecha de nacimiento del actor o actriz" class="form-control" required value="<?php if (isset($actorObject)) echo $actorObject->getBirthdate(); ?>" />
                        <input type="hidden" name="actorId" value="<?php echo $idActor; ?>" />
                    </div>
                    <div class="mb-3">
                        <label for="actorNationality" class="form-label label-font-size">Nacionalidad del actor o actriz</label>
                        <input id="actorNationality" name="actorNationality" type="text" placeholder="Introduce la nacionalidad del actor o actriz" class="form-control" required value="<?php if (isset($actorObject)) echo $actorObject->getNationality(); ?>" />
                        <input type="hidden" name="actorId" value="<?php echo $idActor; ?>" />
                    </div>
                    <input type="submit" value="Editar" class="btn btn-primary" name="editBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $actorEdited = false;

        if (isset($_POST['editBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['actorRepeated'])) {

        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger ms-2" role="alert">
                    El nombre y apellido del actor tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if ((isset($_POST['actorName'])) and (isset($_POST['actorSurname'])) and (isset($_POST['actorBirthdate'])) and (isset($_POST['actorNationality']))) {
                [$actorEdited, $actorRepeated] = $controller->updateActor($_POST['actorId'], $_POST['actorName'], $_POST['actorSurname'], $_POST['actorBirthdate'], $_POST['actorNationality']);
            }
            if ($actorEdited) {
                header("Location: list.php?actorEdited=" . $actorEdited);
            }
            if ($actorRepeated) {
                header("Location: edit.php?id=" . $idActor . "&actorRepeated=" . $actorRepeated);
            } else {
            ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-danger ms-2" role="alert">
                        El actor o actriz no se ha editado correctamente.<br><a href="edit.php">Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }

        ?>
    </div>
</body>

</html>