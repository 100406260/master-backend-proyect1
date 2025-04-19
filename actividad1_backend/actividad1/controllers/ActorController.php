<?php

require_once('../../models/Actor.php');
require_once('BaseController.php');

class ActorController extends BaseController
{

  function listActors()
  {
    $model = new Actor("id", "name", "surname", "birthdate", "nationality");
    $model->setController($this);
    $actorList = $model->getAll();

    $actorObjectArray = [];

    foreach ($actorList as $actorItem) {
      $actorObject = new Actor($actorItem->getId(), $actorItem->getName(), $actorItem->getSurname(), $actorItem->getBirthdate(), $actorItem->getNationality());
      array_push($actorObjectArray, $actorObject);
    }

    return $actorObjectArray;
  }

  function createActors($actorName, $actorSurname, $actorBirthdate, $actorNationality)
  {
    $newActor = new Actor("null", $actorName, $actorSurname, $actorBirthdate, $actorNationality);
    $newActor->setController($this);
    [$actorCreated, $actorRepeated] = $newActor->store();

    return [$actorCreated, $actorRepeated];
  }

  function updateActor($actorId, $actorName, $actorSurname, $actorBirthdate, $actorNationality)
  {
    $actor = new Actor($actorId, $actorName, $actorSurname, $actorBirthdate, $actorNationality);
    $actor->setController($this);
    [$actorEdited, $actorRepeated] = $actor->update();

    return [$actorEdited, $actorRepeated];
  }

  function getActorData($actorId, $actorName, $actorSurname, $actorBirthdate, $actorNationality)
  {
    $actor = new Actor($actorId, $actorName, $actorSurname, $actorBirthdate, $actorNationality);
    $actor->setController($this);
    $actorObject = $actor->getItem();

    return $actorObject;
  }

  function deleteActor($actorId)
  {
    $actorData = $this->getActorData($actorId, '', '', '', '');
    if ($actorData) {
      $actorName = $actorData->getName();
      $actorSurname = $actorData->getSurname();
      $actorBirthdate = $actorData->getBirthdate();
      $actorNationality = $actorData->getNationality();
      $actor = new Actor($actorId, $actorName, $actorSurname, $actorBirthdate, $actorNationality);
      $actor->setController($this);
      $actorDeleted = $actor->delete();

      return $actorDeleted;
    } else {
      echo "No se enceuntra la plataforma";
    }
  }
}
?>