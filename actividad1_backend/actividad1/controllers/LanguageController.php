<?php

require_once('../../models/Language.php');
require_once('BaseController.php');

class LanguageController extends BaseController
{

  function listLanguages()
  {
    $model = new Language("id", "name", "ISOcode");
    $model->setController($this);
    $languageList = $model->getAll();

    $languageObjectArray = [];

    foreach ($languageList as $languageItem) {
      $languageObject = new Language($languageItem->getId(), $languageItem->getName(), $languageItem->getISOcode());
      array_push($languageObjectArray, $languageObject);
    }

    return $languageObjectArray;
  }

  function createLanguages($languageName, $languageISOcode)
  {
    if (strlen($languageISOcode) > 5) {
      // ISO Code tiene más de 5 caracteres, devuelve falso (error)
      return false;
    }

    $newLanguage = new Language("null", $languageName, $languageISOcode);
    $newLanguage->setController($this);

    [$languageCreated, $isoError]  = $newLanguage->store();

    return [$languageCreated, $isoError];
  }

  function updateLanguage($languageId, $languageName, $languageISOcode)
  {
    $languageEdited = true;
    if (strlen($languageISOcode) > 5) {
      // ISO Code tiene más de 5 caracteres, devuelve falso (error)
      $languageEdited = false;
    }
    $language = new Language($languageId, $languageName, $languageISOcode);
    $language->setController($this);
    [$languageEdited, $isoError] = $language->update();

    return [$languageEdited, $isoError];
  }

  function getLanguageData($languageId, $languageName, $languageISOcode)
  {
    $language = new Language($languageId, $languageName, $languageISOcode);
    $language->setController($this);
    $languageObject = $language->getItem();

    return $languageObject;
  }

  function deleteLanguage($languageId)
  {
    $languageData = $this->getLanguageData($languageId, '', '', '', '');
    if ($languageData) {
      $languageName = $languageData->getName();
      $languageISOcode = $languageData->getISOcode();
      $language = new Language($languageId, $languageName, $languageISOcode);
      $language->setController($this);
      $languageDeleted = $language->delete();

      return $languageDeleted;
    } else {
      echo "No se enceuntra el idioma";
    }
  }
}
?>