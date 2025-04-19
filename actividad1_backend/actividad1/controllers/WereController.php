<?php

require_once('../../models/Were.php');
require_once('BaseController.php');

class WereController extends BaseController
{

  function listWere()
  {
    $model = new Were("idSerie", "idPlatform");
    $model->setController($this);
    $wereList = $model->getAll();

    $wereObjectArray = [];

    foreach ($wereList as $wereItem) {
      $wereObject = new Were($wereItem->getIdSerie(), $wereItem->getIdPlatform());
      array_push($wereObjectArray, $wereObject);
    }

    return $wereObjectArray;
  }

  function createWere($serieId, $platformsId)
  {
    $wereCreated = false;

    if (!empty($platformsId)) {
      foreach ($platformsId as $idPlatform) {
        $newWere = new Were($serieId, $idPlatform);
        $newWere->setController($this);
        $wereCreated = $newWere->store();
      }
    }

    return $wereCreated;
  }

  function updateWere($serieId, $platformsId)
  {
    $wereEdited = false;

    $wereAux = new Were($serieId, '1');
    $wereAux->setController($this);
    $wereDeleted = $wereAux->delete();

    if ($wereDeleted && !empty($platformsId)) {
      foreach ($platformsId as $idPlatform) {
        $were = new Were($serieId, $idPlatform);
        $were->setController($this);
        $wereEdited = $were->update();
      }
    }

    return $wereEdited;
  }

  function getWereData($serieId, $platformId)
  {
    $were = new Were($serieId, $platformId);
    $were->setController($this);
    $wereObject = $were->getItem();

    return $wereObject;
  }
}
?>