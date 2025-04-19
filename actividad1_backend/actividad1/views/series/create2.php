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


$serieController = new SerieController();
$platformController = new PlatformController();
$actorController = new ActorController();
$directorController = new DirectorController();
$langController = new LanguageController();
$wereController = new WereController();
$appearController = new AppearController();
$haveController = new HaveController();
$listenController = new ListenController();
$leerController = new LeerController();

$platforms = $platformController->listPlatforms();
$actors = $actorController->listActors();
$directors = $directorController->listDirectors();
$languages = $langController->listLanguages();

?>
<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <title>Actividad 1</title>

</head>

<body>
    <div class="container mt-3 mb-5">
        <div class="row">
            <div class="container-title">
                <?php
                if (isset($_GET['serieName'])) {
                    echo '<h1 class="title">' . $_GET['serieName'] . ' </h1>';
                }
                ?>
            </div>
            <div class="col-8">
                <form name="create_serie" action="" method="POST">
                    <div class="mb-3">
                        <p id="selectedPlatforms"></p>
                        <label for="platform-select" class="form-label label-font-size">Plataformas donde aparece la serie </label>
                        <select class="form-select" name="platforms[]" id="platform-select" multiple="multiple">
                            <?php
                            foreach ($platforms as $platform) {
                                echo '<option value="' . $platform->getId() . '">' . $platform->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedActors"></p>
                        <label for="actor-select" class="form-label label-font-size">Actores y actrices que aparecen en la serie </label>
                        <select class="form-select" name="actors[]" id="actor-select" multiple="multiple">
                            <?php
                            foreach ($actors as $actor) {
                                echo '<option value="' . $actor->getId() . '">' . $actor->getName() . ' ' . $actor->getSurname() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedDirectors"></p>
                        <label for="director-select" class="form-label label-font-size">Director o directores de la serie </label>
                        <select class="form-select" name="directors[]" id="director-select" multiple="multiple">
                            <?php
                            foreach ($directors as $director) {
                                echo '<option value="' . $director->getId() . '">' . $director->getName() . ' ' . $director->getSurname() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedAudio"></p>
                        <label for="audio-select" class="form-label label-font-size">Idiomas de audio en los que esta disponible la serie </label>
                        <select class="form-select" name="audios[]" id="audio-select" multiple="multiple">
                            <?php
                            foreach ($languages as $audio) {
                                echo '<option value="' . $audio->getId() . '">' . $audio->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <p id="selectedSub"></p>
                        <label for="sub-select" class="form-label label-font-size">Idiomas de subtítulos en los que esta disponible la serie </label>
                        <select class="form-select" name="subs[]" id="sub-select" multiple="multiple">
                            <?php
                            foreach ($languages as $sub) {
                                echo '<option value="' . $sub->getId() . '">' . $sub->getName() . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <input type="submit" value="Crear" class="btn btn-primary" name="craeteBtn" />
                </form>
            </div>
        </div>

        <?php

        $sendData = false;
        $serieCreated = false;

        if (isset($_POST['craeteBtn'])) {
            $sendData = true;
        }
        if ($sendData) {
            //plataformas
            $selectedPlatforms = [];
            if (isset($_POST['platforms'])) {
                $selectedPlatforms = $_POST['platforms'];
            }

            $seriePlatformsCreated = $wereController->createWere($_GET['id'], $selectedPlatforms);

            //actores
            $selectedActors = [];
            if (isset($_POST['actors'])) {
                $selectedActors = $_POST['actors'];
            }

            $serieActorsCreated = $appearController->createAppear($_GET['id'], $selectedActors);

            //directores
            $selectedDirectors = [];
            if (isset($_POST['directors'])) {
                $selectedDirectors = $_POST['directors'];
            }

            $serieDirectorsCreated = $haveController->createHave($_GET['id'], $selectedDirectors);

            //audio
            $selectedAudio = [];
            if (isset($_POST['audios'])) {
                $selectedAudio = $_POST['audios'];
            }

            $serieAudioCreated = $listenController->createListen($_GET['id'], $selectedAudio);

            //subt
            $selectedSub = [];
            if (isset($_POST['subs'])) {
                $selectedSub = $_POST['subs'];
            }
            $serieSubCreated = $leerController->createLeer($_GET['id'], $selectedSub);


            if ($seriePlatformsCreated || $serieActorsCreated || $serieDirectorsCreated || $serieAudioCreated || $serieSubCreated) {
        ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-success ms-2" role="alert">
                        Serie editada correctamente. <br><a href="list.php"> Volver al listado de series.</a>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="row mt-3 col-8">
                    <div class="alert alert-danger ms-2" role="alert">
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