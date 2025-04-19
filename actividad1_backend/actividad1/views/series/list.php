<?php
require_once('../../controllers/SerieController.php');

$controller = new SerieController();
$series = $controller->listSeries();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
  <title>Actividad 1</title>
</head>

<body>
  <div class="container mt-3 mb-5">
    <div class="d-flex justify-content-between">
      <div class="container-title col-md-5 ">
        <h1 class="title">Listado de series</h1>
      </div>
      <a class="btn btn-outline-primary align-self-center col-md-2" href="create.php">
        <i class="fas fa-plus"></i> Añadir serie
      </a>
    </div>

    <div class="mt-3">
      <?php if (count($series) > 0) { ?>
        <table class="table text-center">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Plataformas</th>
              <th>Actores y actrices</th>
              <th>Directores y directoras</th>
              <th>Idiomas de audio</th>
              <th>Idiomas de subtítulos</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($series as $serie) { ?>
              <tr>
                <td><?php echo $serie[1]; ?></td>
                <td>
                  <ul class="list-unstyled">
                    <?php foreach ($serie[2] as $platform) { ?>
                      <li><?php echo $platform; ?></li>
                    <?php } ?>
                  </ul>
                </td>
                <td>
                  <ul class="list-unstyled">
                    <?php foreach ($serie[3] as $actor) { ?>
                      <li><?php echo $actor; ?></li>
                    <?php } ?>
                  </ul>
                </td>
                <td>
                  <ul class="list-unstyled">
                    <?php foreach ($serie[4] as $director) { ?>
                      <li><?php echo $director; ?></li>
                    <?php } ?>
                  </ul>
                </td>
                <td>
                  <ul class="list-unstyled">
                    <?php foreach ($serie[5] as $audio) { ?>
                      <li><?php echo $audio; ?></li>
                    <?php } ?>
                  </ul>
                </td>
                <td>
                  <ul class="list-unstyled">
                    <?php foreach ($serie[6] as $sub) { ?>
                      <li><?php echo $sub; ?></li>
                    <?php } ?>
                  </ul>
                </td>
                <td class="button-container">
                  <div class="d-flex justify-content-end">
                    <a class="btn btn-outline-success btn-sm me-2" href="edit.php?id=<?php echo $serie[0]; ?>">
                      <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                    <form name="delete_serie" action="delete.php" method="POST" class="d-inline">
                      <input type="hidden" name="serieId" value=<?php echo $serie[0]; ?> />
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Borrar
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      <?php } else { ?>
        <div class="text-center mt-3">
          Aún no existen series.
        </div>
      <?php } ?>
    </div>
    <div class="create-msg">
      <?php
      if (isset($_GET['serieCreated'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Serie creada correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
    <div class="edit-msg">
      <?php
      if (isset($_GET['serieEdited'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Serie editada correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-bRdGC6raRjnO2TQeUn8s7Ie7Gb9zGqbn4fOz9sDL/Qq2UefKCTA5F5bs56jT1Wyw" crossorigin="anonymous"></script>
</body>

</html>