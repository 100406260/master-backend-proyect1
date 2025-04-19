<?php
require_once('../../controllers/ActorController.php');

$controller = new ActorController();
$actors = $controller->listActors();
?>

<!DOCTYPE html>
<html>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <title>Actividad 1</title>

</head>

<body>
  <div class="container mt-3">
    <div class="d-flex justify-content-between">
      <div class="container-title col-md-5 ">
        <h1 class="title">Listado de actores</h1>
      </div>
      <a class="btn btn-outline-primary align-self-center col-md-2" href="create.php">
        <i class="fas fa-plus"></i> Añadir actor
      </a>
    </div>

    <div class="mt-3">
      <?php
      $actorList = $controller->listActors();
      if (count($actorList) > 0) {
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
            foreach ($actorList as $actor) {
            ?>
              <tr>
                <td><?php echo $actor->getId(); ?></td>
                <td><?php echo $actor->getName(); ?></td>
                <td><?php echo $actor->getSurname(); ?></td>
                <td>
                  <?php
                  $birthdate =  $actor->getBirthdate();
                  $newDate = date("d-m-Y", strtotime($birthdate));
                  echo $newDate;
                  ?>
                </td>
                <td class="name-cell">
                  <?php echo $actor->getNationality(); ?>
                </td>
                <td class="button-container">
                  <div class="d-flex justify-content-end">
                    <a class="btn btn-outline-success btn-sm me-2" href="edit.php?id=<?php echo $actor->getId(); ?>">
                      <i class="fas fa-pencil-alt"></i> Editar
                    </a>
                    <form name="delete_actor" action="delete.php" method="POST" class="d-inline">
                      <input type="hidden" name="actorId" value=<?php echo $actor->getId(); ?> />
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
        <div>
          aun no existen
        </div>
      <?php } ?>
    </div>
    <div class="create-msg">
      <?php
      if (isset($_GET['actorCreated'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Actor/actriz creado correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
    <div class="edit-msg">
      <?php
      if (isset($_GET['actorEdited'])) {
      ?>
        <div class="row separation-up col-8">
          <div class="alert alert-success" role="alert">
            Actor/actriz editado correctamente.
          </div>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
</body>

</html>