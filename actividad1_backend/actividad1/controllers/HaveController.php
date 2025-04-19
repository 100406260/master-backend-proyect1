<?php

require_once('../../models/Have.php');
require_once('BaseController.php');

class HaveController extends BaseController
{

  function listHave()
  {
    $model = new Have("idSerie", "idDirector");
    $model->setController($this);
    $haveList = $model->getAll();

    $haveObjectArray = [];

    foreach ($haveList as $haveItem) {
      $haveObject = new Have($haveItem->getIdSerie(), $haveItem->getIdDirector());
      array_push($haveObjectArray, $haveObject);
    }

    return $haveObjectArray;
  }

  function createHave($serieId, $directorsId)
  {
    $haveCreated = false;

    if (!empty($directorsId)) {
      foreach ($directorsId as $idDirector) {
        $newHave = new Have($serieId, $idDirector);
        $newHave->setController($this);
        $haveCreated = $newHave->store();
      }
    }
    return $haveCreated;
  }

  function updateHave($serieId, $directorsId)
  {
    $haveEdited = false;

    $haveAux = new Have($serieId, '1');
    $haveAux->setController($this);
    $haveDeleted = $haveAux->delete();

    if ($haveDeleted && !empty($directorsId)) {
      foreach ($directorsId as $idDirector) {
        $have = new Have($serieId, $idDirector);
        $have->setController($this);
        $haveEdited = $have->update();
      }
    }

    return $haveEdited;
  }

  function getHaveData($serieId, $directorId)
  {
    $have = new Have($serieId, $directorId);
    $have->setController($this);
    $haveObject = $have->getItem();

    return $haveObject;
  }
}
?>