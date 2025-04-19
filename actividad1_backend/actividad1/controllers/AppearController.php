<?php

require_once('../../models/Appear.php');
require_once('BaseController.php');

class AppearController extends BaseController
{


  function listAppears()
  {
    $model = new Appear("idSerie", "idActor");
    $model->setController($this);
    $appearList = $model->getAll();

    $appearObjectArray = [];

    foreach ($appearList as $appearItem) {
      $appearObject = new Appear($appearItem->getIdSerie(), $appearItem->getIdActor());
      array_push($appearObjectArray, $appearObject);
    }

    return $appearObjectArray;
  }

  function createAppear($serieId, $actorsId)
  {
    $appearCreated = false;

    if (!empty($actorsId)) {
      foreach ($actorsId as $idActor) {
        $newAppear = new Appear($serieId, $idActor);
        $newAppear->setController($this);
        $appearCreated = $newAppear->store();
      }
    }
    return $appearCreated;
  }

  function updateAppear($serieId, $actorsId)
  {
    $appearEdited = false;

    $appearAux = new Appear($serieId, '1');
    $appearAux->setController($this);
    $appearDeleted = $appearAux->delete();

    if ($appearDeleted && !empty($actorsId)) {
      foreach ($actorsId as $idActor) {
        $appear = new Appear($serieId, $idActor);
        $appear->setController($this);
        $appearEdited = $appear->update();
      }
    }

    return $appearEdited;
  }

  function getAppearData($serieId, $actorId)
  {
    $appear = new Appear($serieId, $actorId);
    $appear->setController($this);
    $appearObject = $appear->getItem();

    return $appearObject;
  }
}
?>
