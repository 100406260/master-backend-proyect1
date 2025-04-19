<?php
require_once('../../controllers/PlatformController.php');

$controller = new PlatformController();
$platforms = $controller->listPlatforms();
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
  <div class="container mt-3">
    <div class="d-flex justify-content-between">
      <div class="container-title col-md-5 ">
        <h1 class="title">Listado de plataformas</h1>
      </div>
      <a class="btn btn-outline-primary align-self-center col-md-2" href="create.php">
        <i class="fas fa-plus"></i> Añadir plataforma
      </a>
    </div>

    <div class="mt-3">
      <?php
      $platformList = $controller->listPlatforms();
      if (count($platformList) > 0) {
      ?>
        <table class="table text-center">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($platformList as $platform) {
            ?>
              <tr>
                <td><?php echo $platform->getId(); ?></td>
                <td class="name-cell"><?php echo $platform->getName(); ?></td>
                <td class="button-container">
                  <div class="d-flex justify-content-end">
                    <a class="btn btn-outline-success btn-sm me-2" href="edit.php?id=<?php echo $platform->getId(); ?>">
                      <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                    <form name="delete_platform" action="delete.php" method="POST" class="d-inline">
                      <input type="hidden" name="platformId" value=<?php echo $platform->getId(); ?> />
                      <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-trash-alt"></i> Borrar
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
        </table>
      <?php
      } else {
      ?>
        <div class="text-center mt-3">
          Aun no existen plataformas.
        </div>
      <?php } ?>
    </div>
    <div class="create-msg">
      <?php
      if (isset($_GET['platformCreated'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Plataforma creada correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
    <div class="edit-msg">
      <?php
      if (isset($_GET['platformEdited'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Plataforma editada correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>