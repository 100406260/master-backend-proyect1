<?php
require_once('../../controllers/SerieController.php');
require_once('../../controllers/PlatformController.php');
require_once('../../controllers/ActorController.php');
require_once('../../controllers/DirectorController.php');
require_once('../../controllers/LanguageController.php');
require_once('../../controllers/WereController.php');
require_once('../../controllers/AppearController.php');
require_once('../../controllers/HaveController.php');
require_once('../../controllers/ListenController.php');
require_once('../../controllers/LeerController.php');

$controller = new SerieController();
$platformController = new PlatformController();
$actorController = new ActorController();
$directorController = new DirectorController();
$langController = new LanguageController();
$wereController = new WereController();
$appearController = new AppearController();
$haveController = new HaveController();
$listenController = new ListenController();
$leerController = new LeerController();

$platformsList = $platformController->listPlatforms();
$actorsList = $actorController->listActors();
$directorsList = $directorController->listDirectors();
$languagesList = $langController->listLanguages();

//name
if (isset($_GET['id'])) {
    $idSerie = $_GET['id'];
    $titleSerie = '';
    $serieObject = $controller->getSerieData($idSerie, $titleSerie);
} else {
    echo "ID Serie NO ESPECIFICADO";
}

//platform
if (isset($_GET['id'])) {
    $idSerieWere = $_GET['id'];
    $idPlatform = '';
    $wereObject = $wereController->getWereData($idSerieWere, $idPlatform);
} else {
    echo "ID Plataforma NO ESPECIFICADO";
}

//actor
if (isset($_GET['id'])) {
    $idSerieAppear = $_GET['id'];
    $idActor = '';
    $appearObject = $appearController->getAppearData($idSerieAppear, $idActor);
} else {
    echo "ID Actor NO ESPECIFICADO";
}

//director
if (isset($_GET['id'])) {
    $idSerieHave = $_GET['id'];
    $idDirector = '';
    $haveObject = $haveController->getHaveData($idSerieHave, $idDirector);
} else {
    echo "ID Director NO ESPECIFICADO";
}

//idioma audio
if (isset($_GET['id'])) {
    $idSerieListen = $_GET['id'];
    $idLanguague = '';
    $listenObject = $listenController->getListenData($idSerieListen, $idLanguague);
} else {
    echo "ID idioma audio NO ESPECIFICADO";
}

//idioma subtitulo
if (isset($_GET['id'])) {
    $idSerieLeer = $_GET['id'];
    $idLanguague = '';
    $leerObject = $leerController->getLeerData($idSerieLeer, $idLanguague);
} else {
    echo "ID idioma subtitulo NO ESPECIFICADO";
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
    <div class="container mt-5 mb-5">
        <h1 class="mb-4">Editar serie</h1>
        <div class="row">
            <div class="col-md-8">
                <form name="edit_serie" action="" method="POST">
                    <div class="mb-3">
                        <label for="serieName" class="form-label label-font-size">Nombre de la serie</label>
                        <input id="serieName" name="serieName" type="text" placeholder="Introduce el título de la serie" class="form-control" required value="<?php if (isset($serieObject)) echo $serieObject->getTitle(); ?>" />
                        <input type="hidden" name="serieId" value="<?php echo $idSerie; ?>" />
                    </div>
                    <div class="mb-3">
                        <p id="selectedPlatforms"></p>
                        <label for="platform-select" class="form-label label-font-size">Plataformas donde aparece la serie </label>
                        <select class="form-select" name="platforms[]" id="platform-select" size="5" multiple="multiple">
                            <?php
                            foreach ($platformsList as $platform) {
                                echo '<option';
                                foreach ($wereObject as $were) {
                                    if ($platform->getId() === $were->getIdPlatform()) {
                                        echo ' selected ';
                                    }
                                }
                                echo ' value="' . $platform->getId() . '">' . $platform->getName() . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedActors"></p>
                        <label for="actor-select" class="form-label label-font-size">Actores y actrices que aparecen en la serie </label>
                        <select class="form-select" name="actors[]" id="actor-select" size="5" multiple="multiple">
                            <?php
                            foreach ($actorsList as $actor) {
                                echo '<option';
                                foreach ($appearObject as $appear) {
                                    if ($actor->getId() === $appear->getIdActor()) {
                                        echo ' selected ';
                                    }
                                }
                                echo ' value="' . $actor->getId() . '">' . $actor->getName() . ' ' . $actor->getSurname() . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedDirectors"></p>
                        <label for="director-select" class="form-label label-font-size">Directores y directoras de la serie </label>
                        <select class="form-select" name="directors[]" id="director-select" size="5" multiple="multiple">
                            <?php
                            foreach ($directorsList as $director) {
                                echo '<option';
                                foreach ($haveObject as $have) {
                                    if ($director->getId() === $have->getIdDirector()) {
                                        echo ' selected ';
                                    }
                                }
                                echo ' value="' . $director->getId() . '">' . $director->getName() . ' ' . $director->getSurname() . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedAudio"></p>
                        <label for="audio-select" class="form-label label-font-size">Idiomas de audio en los que esta disponible la serie </label>
                        <select class="form-select" name="audios[]" id="audio-select" size="5" multiple="multiple">
                            <?php
                            foreach ($languagesList as $language) {
                                echo '<option';
                                foreach ($listenObject as $listen) {
                                    if ($language->getId() === $listen->getIdAudio()) {
                                        echo ' selected ';
                                    }
                                }
                                echo ' value="' . $language->getId() . '">' . $language->getName()  . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedSub"></p>
                        <label for="sub-select" class="form-label label-font-size">Idiomas de subtítulos en los que esta disponible la serie </label>
                        <select class="form-select" name="subs[]" id="sub-select" size="5" multiple="multiple">
                            <?php
                            foreach ($languagesList as $language) {
                                echo '<option';
                                foreach ($leerObject as $leer) {
                                    if ($language->getId() === $leer->getIdSub()) {
                                        echo ' selected ';
                                    }
                                }
                                echo ' value="' . $language->getId() . '">' . $language->getName()  . '</option>';
                            }

                            ?>
                        </select>
                    </div>

                    <input type="submit" value="Editar" class="btn btn-primary" name="editBtn" />
                </form>
            </div>
        </div>

        <?php
        $sendData = false;
        $serieEdited = false;
        $seriePlatformEdited = false;


        if (isset($_POST['editBtn'])) {
            $sendData = true;
        }
        if (isset($_GET['nameRepeated'])) {
        ?>
            <div class="row mt-3 col-8">
                <div class="alert alert-danger ms-2" role="alert">
                    El nombre de la serie tiene que ser unico.
                </div>
            </div>
            <?php
        }
        if ($sendData) {
            if ((isset($_POST['serieName']))) {
                [$serieEdited, $nameRepeated] = $controller->updateSerie($_POST['serieId'], $_POST['serieName']);

                //plataformas
                $selectedPlatforms = [];
                if (isset($_POST['platforms'])) {
                    $selectedPlatforms = $_POST['platforms'];
                }

                $seriePlatformEdited = $wereController->updateWere($_POST['serieId'], $selectedPlatforms);

                //actores
                $selectedActors = [];
                if (isset($_POST['actors'])) {
                    $selectedActors = $_POST['actors'];
                }

                $serieActorEdited = $appearController->updateAppear($_POST['serieId'], $selectedActors);

                //directores
                $selectedDirectors = [];
                if (isset($_POST['directors'])) {
                    $selectedDirectors = $_POST['directors'];
                }

                $serieDirectorEdited = $haveController->updateHave($_POST['serieId'], $selectedDirectors);

                //audio
                $selectedAudio = [];
                if (isset($_POST['audios'])) {
                    $selectedAudio = $_POST['audios'];
                }

                $serieLangAEdited = $listenController->updateListen($_POST['serieId'], $selectedAudio);

                //subtitulo
                $selectedSub = [];
                if (isset($_POST['subs'])) {
                    $selectedSub = $_POST['subs'];
                }

                $serieLangSEdited = $leerController->updateLeer($_POST['serieId'], $selectedSub);
            }
            if ($nameRepeated) {
            ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-danger" role="alert">
                        El nombre de la serie tiene que ser unico.
                    </div>
                </div>
                <?php
            }

            if (!$nameRepeated) {
                if ($serieEdited || $seriePlatformEdited || $serieActorEdited || $serieDirectorEdited || $serieLangAEdited || $serieLangSEdited) {
                ?>
                    <div class="row mt-3 col-8">
                        <div class="alert alert-success ms-2" role="alert">
                            Serie editada correctamente. <br><a href="list.php"> Volver al listado de series.</a>
                        </div>
                    </div>
                <?php
                }
            } else {
                $urlEdit = "edit.php?id=" . $idSerie;
                ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-danger ms-2" role="alert">
                        La serie no se ha editado correctamente.<br><a href=<?php $urlEdit ?>>Volver a intentarlo.</a>
                    </div>
                </div>
        <?php
            }
        }

        ?>
    </div>
</body>

</html>