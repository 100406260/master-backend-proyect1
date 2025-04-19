<?php
require_once('../../controllers/DirectorController.php');

$controller = new DirectorController();
$directors = $controller->listDirectors();
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
        <h1 class="title">Listado de directores</h1>
      </div>
      <a class="btn btn-outline-primary align-self-center col-md-2" href="create.php">
        <i class="fas fa-plus"></i> Añadir director
      </a>
    </div>

    <div class="mt-3">
      <?php
      $directorList = $controller->listDirectors();
      if (count($directorList) > 0) {
      ?>
        <table class="table text-center">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
              <th>Apellidos</th>
              <th>Fecha de nacimiento</th>
              <th>Nacionalidad</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($directorList as $director) {
            ?>
              <tr>
                <td><?php echo $director->getId(); ?></td>
                <td><?php echo $director->getName(); ?></td>
                <td><?php echo $director->getSurname(); ?></td>
                <td>
                  <?php
                  $birthdate =  $director->getBirthdate();
                  $newDate = date("d-m-Y", strtotime($birthdate));
                  echo $newDate;
                  ?>
                </td>
                <td class="name-cell"><?php echo $director->getNationality(); ?></td>
                <td class="button-container">
                  <div class="d-flex justify-content-end">
                    <a class="btn btn-outline-success btn-sm me-2" href="edit.php?id=<?php echo $director->getId(); ?>">
                      <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                    <form name="delete_director" action="delete.php" method="POST" class="d-inline">
                      <input type="hidden" name="directorId" value=<?php echo $director->getId(); ?> />
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
          Aún no existen directores.
        </div>
      <?php } ?>
    </div>
    <div class="create-msg">
      <?php
      if (isset($_GET['directorCreated'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Director creado correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
    <div class="edit-msg">
      <?php
      if (isset($_GET['directorEdited'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Director editado correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>