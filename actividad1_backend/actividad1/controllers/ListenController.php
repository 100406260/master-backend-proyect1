<?php

require_once('../../models/Listen.php');
require_once('BaseController.php');

class ListenController extends BaseController
{

  function listListen()
  {
    $model = new Listen("idSerie", "idAudio");
    $model->setController($this);
    $listenList = $model->getAll();

    $listenObjectArray = [];

    foreach ($listenList as $listenItem) {
      $listenObject = new Listen($listenItem->getIdSerie(), $listenItem->getIdAudio());
      array_push($listenObjectArray, $listenObject);
    }

    return $listenObjectArray;
  }

  function createListen($serieId, $langsId)
  {
    $listenCreated = false;

    if (!empty($langsId)) {
      foreach ($langsId as $idLang) {
        $newListen = new Listen($serieId, $idLang);
        $newListen->setController($this);
        $listenCreated = $newListen->store();
      }
    }
    return $listenCreated;
  }

  function updateListen($serieId, $langsId)
  {
    $listenEdited = false;

    $listenAux = new Listen($serieId, '1');
    $listenAux->setController($this);
    $listenDeleted = $listenAux->delete();

    if ($listenDeleted  && !empty($langsId)) {
      foreach ($langsId as $idLang) {
        $listen = new Listen($serieId, $idLang);
        $listen->setController($this);
        $listenEdited = $listen->update();
      }
    }

    return $listenEdited;
  }

  function getListenData($serieId, $langId)
  {
    $listen = new Listen($serieId, $langId);
    $listen->setController($this);
    $listenObject = $listen->getItem();

    return $listenObject;
  }
}
?>