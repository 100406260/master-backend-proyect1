<?php

require_once('../../models/Platform.php');
require_once('BaseController.php');

class PlatformController extends BaseController
{

  function listPlatforms()
  {
    $model = new Platform("id", "name");
    $model->setController($this);
    $platformList = $model->getAll();

    $platformObjectArray = [];

    foreach ($platformList as $platformItem) {
      $platformObject = new Platform($platformItem->getId(), $platformItem->getName());
      array_push($platformObjectArray, $platformObject);
    }

    return $platformObjectArray;
  }

  function createPlatforms($platformName)
  {
    $newPlatform = new Platform("null", $platformName);
    $newPlatform->setController($this);
    [$platformCreated, $nameRepeated] = $newPlatform->store();

    return [$platformCreated, $nameRepeated];
  }

  function updatePlatform($platformId, $platformName)
  {
    $platform = new Platform($platformId, $platformName);
    $platform->setController($this);
    [$platformEdited, $nameRepeated]  = $platform->update();

    return [$platformEdited, $nameRepeated];
  }

  function getPlatformData($idPlatform, $namePlatform)
  {
    $platform = new Platform($idPlatform, $namePlatform);
    $platform->setController($this);
    $platformObject = $platform->getItem();

    return $platformObject;
  }

  function deletePlatform($platformId)
  {
    $platformData = $this->getPlatformData($platformId, '');
    if ($platformData) {
      $platformName = $platformData->getName();
      $platform = new Platform($platformId, $platformName);
      $platform->setController($this);
      $platformDeleted = $platform->delete();

      return $platformDeleted;
    } else {
      echo "No se enceuntra la plataforma";
    }
  }
}
?>