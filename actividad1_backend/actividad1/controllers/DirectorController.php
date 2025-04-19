<?php

require_once('../../models/Director.php');
require_once('BaseController.php');

class DirectorController extends BaseController
{

  function listDirectors()
  {
    $model = new Director("id", "name", "surname", "birthdate", "nationality");
    $model->setController($this);
    $directorList = $model->getAll();

    $directorObjectArray = [];

    foreach ($directorList as $directorItem) {
      $directorObject = new Director($directorItem->getId(), $directorItem->getName(), $directorItem->getSurname(), $directorItem->getBirthdate(), $directorItem->getNationality());
      array_push($directorObjectArray, $directorObject);
    }

    return $directorObjectArray;
  }

  function createDirectors($directorName, $directorSurname, $directorBirthdate, $directorNationality)
  {
    $newDirector = new Director("null", $directorName, $directorSurname, $directorBirthdate, $directorNationality);
    $newDirector->setController($this);
    [$directorCreated, $directorRepeated] = $newDirector->store();

    return [$directorCreated, $directorRepeated];
  }

  function updateDirector($directorId, $directorName, $directorSurname, $directorBirthdate, $directorNationality)
  {
    $director = new Director($directorId, $directorName, $directorSurname, $directorBirthdate, $directorNationality);
    $director->setController($this);
    [$directorEdited, $directorRepeated] = $director->update();

    return [$directorEdited, $directorRepeated];
  }

  function getDirectorData($directorId, $directorName, $directorSurname, $directorBirthdate, $directorNationality)
  {
    $director = new Director($directorId, $directorName, $directorSurname, $directorBirthdate, $directorNationality);
    $director->setController($this);
    $directorObject = $director->getItem();

    return $directorObject;
  }

  function deleteDirector($directorId)
  {
    $directorData = $this->getDirectorData($directorId, '', '', '', '');
    if ($directorData) {
      $directorName = $directorData->getName();
      $directorSurname = $directorData->getSurname();
      $directorBirthdate = $directorData->getBirthdate();
      $directorNationality = $directorData->getNationality();
      $director = new Director($directorId, $directorName, $directorSurname, $directorBirthdate, $directorNationality);
      $director->setController($this);
      $directorDeleted = $director->delete();

      return $directorDeleted;
    } else {
      echo "No se enceuntra la plataforma";
    }
  }
}
?>