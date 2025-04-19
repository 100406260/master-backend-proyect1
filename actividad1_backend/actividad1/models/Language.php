<?php

class Language
{
    private $id;
    private $name;
    private $ISOcode;


    private $controller;

    public function __construct($idLanguage, $nameLanguage, $ISOcodeLanguage)
    {
        $this->id = $idLanguage;
        $this->name = $nameLanguage;
        $this->ISOcode = $ISOcodeLanguage;
    }

    public function setController($controller)
    {
        $this->controller = $controller;
    }

    public function setDbConnection($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getISOcode()
    {
        return $this->ISOcode;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $ISOcode
     */
    public function setISOcode($ISOcode)
    {
        $this->ISOcode = $ISOcode;
    }



    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Languages");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Language($item['id'], $item['name'], $item['ISOcode']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $languageCreated = false;
        $isoError = true;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Languages WHERE ISOcode = '$this->ISOcode'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            if ($resultInsert = $mysqli->query("INSERT INTO Languages (name, ISOcode) VALUES ('$this->name','$this->ISOcode')")) {
                $languageCreated = true;
                $isoError = false;
            }
        }

        $mysqli->close();
        return [$languageCreated, $isoError];
    }

    public function update()
    {
        $LanguageEdited = false;
        $isoError = true;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Languages WHERE ISOcode = '$this->ISOcode'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            if ($query = $mysqli->query("UPDATE Languages set name = '" . $this->name . "', ISOcode = '" . $this->ISOcode . "' WHERE id = " . $this->id)) {
                $LanguageEdited = true;
                $isoError = false;
            }
        }
        $mysqli->close();
        return [$LanguageEdited, $isoError];
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Languages WHERE id = '" . $this->id . "'");

        $itemObject = null;
        foreach ($query as $item) {
            $itemObject = new Language($item['id'], $item['name'], $item['ISOcode']);
            break;
        }

        $mysqli->close();
        return $itemObject;
    }

    public function delete()
    {
        $LanguageDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        $idLanguageOK = rtrim($this->id, '/');

        //se comprueba que existe el id antes de borrar
        $queryCheck = "SELECT * FROM Languages WHERE id = '$idLanguageOK'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) != 0) {
            if ($query = $mysqli->query("DELETE FROM  Languages WHERE id = " . $idLanguageOK)) {
                $LanguageDeleted = true;
            }
        }
        $mysqli->close();
        return $LanguageDeleted;
    }
}
?>