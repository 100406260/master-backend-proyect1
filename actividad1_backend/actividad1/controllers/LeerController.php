<?php

require_once('../../models/Leer.php');
require_once('BaseController.php');


class LeerController extends BaseController
{

  function listLeer()
  {
    $model = new Leer("idSerie", "idSub");
    $model->setController($this);
    $leerList = $model->getAll();

    $leerObjectArray = [];

    foreach ($leerList as $leerItem) {
      $leerObject = new Leer($leerItem->getIdSerie(), $leerItem->getIdSub());
      array_push($leerObjectArray, $leerObject);
    }

    return $leerObjectArray;
  }

  function createLeer($serieId, $langsId)
  {
    $leerCreated = false;

    if (!empty($langsId)) {
      foreach ($langsId as $idLang) {
        $newLeer = new Leer($serieId, $idLang);
        $newLeer->setController($this);
        $leerCreated = $newLeer->store();
      }
    }
    return $leerCreated;
  }

  function updateLeer($serieId, $langsId)
  {
    $leerEdited = false;

    $leerAux = new Leer($serieId, '1');
    $leerAux->setController($this);
    $leerDeleted = $leerAux->delete();

    if ($leerDeleted && !empty($langsId)) {
      foreach ($langsId as $idLang) {
        $leer = new Leer($serieId, $idLang);
        $leer->setController($this);
        $leerEdited = $leer->update();
      }
    }

    return $leerEdited;
  }


  function getLeerData($serieId, $langId)
  {
    $leer = new Leer($serieId, $langId);
    $leer->setController($this);
    $leerObject = $leer->getItem();

    return $leerObject;
  }
}
?>