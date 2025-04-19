<?php

require_once('../../models/Serie.php');
require_once('../../models/Were.php');
require_once('../../models/Platform.php');
require_once('../../models/Actor.php');
require_once('../../models/Appear.php');
require_once('../../models/Director.php');
require_once('../../models/Have.php');
require_once('../../models/Language.php');
require_once('../../models/Listen.php');
require_once('../../models/Leer.php');
require_once('BaseController.php');

class SerieController extends BaseController
{

  function listSeries()
  {
    $modelSeries = new Serie("id", "title");
    $modelSeries->setController($this);
    $serieList = $modelSeries->getAll();

    $modelPlatforms = new Platform("id", "name");
    $modelPlatforms->setController($this);
    $platformsList = $modelPlatforms->getAll();

    $modelWere = new Were("idSerie", "idPlatform");
    $modelWere->setController($this);
    $wereList = $modelWere->getAll();

    $modelActors = new Actor("id", "nameActor", "surnameActor", "birthdateActor", "nationalityActor");
    $modelActors->setController($this);
    $actorsList = $modelActors->getAll();

    $modelAppear = new Appear("idSerie", "idActor");
    $modelAppear->setController($this);
    $appearList = $modelAppear->getAll();

    $modelDirectors = new Director("id", "nameDirector", "surnameDirector", "birthdateDirector", "nationalityDirector");
    $modelDirectors->setController($this);
    $directorsList = $modelDirectors->getAll();

    $modelHave = new Have("idSerie", "idDirector");
    $modelHave->setController($this);
    $haveList = $modelHave->getAll();

    $modelLang = new Language("id", "name", "ISOcode");
    $modelLang->setController($this);
    $langList = $modelLang->getAll();

    $modelAudio = new Listen("idSerie", "idAudio");
    $modelAudio->setController($this);
    $audioList = $modelAudio->getAll();

    $modelSub = new Leer("idSerie", "idSub");
    $modelSub->setController($this);
    $subList = $modelSub->getAll();

    $serieObjectArray = [];

    foreach ($serieList as $serieItem) {
      $serieSame = [];
      $serieSameD = [];
      $serieSameA = [];
      $serieSameAudio = [];
      $serieSameSub = [];
      $seriePlatform = [];
      $serieActor = [];
      $serieDirector = [];
      $serieAudio = [];
      $serieSub = [];

      //plataformas
      foreach ($wereList as $wereItem) {
        $id = $wereItem->getIdSerie();
        $serieId = $serieItem->getId();
        if ($id === $serieId) {
          $serieSame[] = $wereItem;
        }
      }

      foreach ($serieSame as $serieFinal) {
        foreach ($platformsList as $platformItem) {
          $idPlatform = $platformItem->getId();
          $idSerieSame = $serieFinal->getIdPlatform();
          if ($idPlatform === $idSerieSame) {
            $seriePlatform[] = $platformItem->getName();
          }
        }
      }

      //actores
      foreach ($appearList as $appearItem) {
        $id = $appearItem->getIdSerie();
        $serieId = $serieItem->getId();
        if ($id === $serieId) {
          $serieSameA[] = $appearItem;
        }
      }

      foreach ($serieSameA as $serieFinalA) {
        foreach ($actorsList as $actorItem) {
          $idActor = $actorItem->getId();
          $idSerieSameA = $serieFinalA->getIdActor();
          if ($idActor === $idSerieSameA) {
            $serieActor[] = $actorItem->getName() . ' ' . $actorItem->getSurname();
          }
        }
      }

      //directores
      foreach ($haveList as $haveItem) {
        $id = $haveItem->getIdSerie();
        $serieId = $serieItem->getId();
        if ($id === $serieId) {
          $serieSameD[] = $haveItem;
        }
      }

      foreach ($serieSameD as $serieFinalD) {
        foreach ($directorsList as $directorItem) {
          $idDirector = $directorItem->getId();
          $idSerieSameD = $serieFinalD->getIdDirector();
          if ($idDirector === $idSerieSameD) {
            $serieDirector[] = $directorItem->getName() . ' ' . $directorItem->getSurname();
          }
        }
      }


      //idiomas audio
      foreach ($audioList as $listenItem) {
        $id = $listenItem->getIdSerie();
        $serieId = $serieItem->getId();
        if ($id === $serieId) {
          $serieSameAudio[] = $listenItem;
        }
      }

      foreach ($serieSameAudio as $serieFinalAudio) {
        foreach ($langList as $langAItem) {
          $idAudio = $langAItem->getId();
          $idSerieSameAudio = $serieFinalAudio->getIdAudio();
          if ($idAudio === $idSerieSameAudio) {
            $serieAudio[] = $langAItem->getName();
          }
        }
      }

      //idiomas subtitulos
      foreach ($subList as $leerItem) {
        $id = $leerItem->getIdSerie();
        $serieId = $serieItem->getId();
        if ($id === $serieId) {
          $serieSameSub[] = $leerItem;
        }
      }

      foreach ($serieSameSub as $serieFinalSub) {
        foreach ($langList as $langSItem) {
          $idSub = $langSItem->getId();
          $idSerieSameSub = $serieFinalSub->getIdSub();
          if ($idSub === $idSerieSameSub) {
            $serieSub[] = $langSItem->getName();
          }
        }
      }


      $serieObject[] = [$serieItem->getId(), $serieItem->getTitle(), $seriePlatform, $serieActor, $serieDirector, $serieAudio, $serieSub];
    }

    return $serieObject;
  }

  function createSerie($serieName)
  {
    $newSerie = new Serie("null", $serieName);
    $newSerie->setController($this);
    [$serieCreated, $idSerie, $nameRepeated] = $newSerie->store();

    return [$serieCreated, $idSerie, $nameRepeated];
  }


  function updateSerie($serieId, $serieTitle)
  {
    $serie = new Serie($serieId, $serieTitle);
    $serie->setController($this);
    [$serieEdited, $nameRepeated] = $serie->update();

    return [$serieEdited, $nameRepeated];
  }

  function getSerieData($idSerie, $titleSerie)
  {
    $serie = new Serie($idSerie, $titleSerie);
    $serie->setController($this);
    $serieObject = $serie->getItem();

    return $serieObject;
  }

  function deleteSerie($serieId)
  {
    $serieData = $this->getSerieData($serieId, '');
    if ($serieData) {
      $serieTitle = $serieData->getTitle();
      $serie = new Serie($serieId, $serieTitle);
      $serie->setController($this);
      $serieDeleted = $serie->delete();

      return $serieDeleted;
    } else {
      echo "No se enceuntra la serie";
    }
  }
}
?>