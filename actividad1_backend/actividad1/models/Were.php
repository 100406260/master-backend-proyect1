<?php

class Were
{
    private $idSerie;
    private $idPlatform;

    private $controller;

    public function __construct($id_serie, $id_platform)
    {
        $this->idSerie = $id_serie;
        $this->idPlatform = $id_platform;
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
    public function getIdSerie()
    {
        return $this->idSerie;
    }

    /**
     * @return mixed
     */
    public function getIdPlatform()
    {
        return $this->idPlatform;
    }

    /**
     * @param mixed $idSerie
     */
    public function setIdSerie($idSerie)
    {
        $this->idSerie = $idSerie;
    }

    /**
     * @param mixed $idPlatform
     */
    public function setIdPlatform($idPlatform)
    {
        $this->idPlatform = $idPlatform;
    }

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Were");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Were($item['id_serie'], $item['id_platform']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $wereCreated = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($resultInsert = $mysqli->query("INSERT INTO Were (id_serie, id_platform) VALUES ('$this->idSerie','$this->idPlatform')")) {
            $wereCreated = true;
        }

        $mysqli->close();
        return $wereCreated;
    }


    public function delete()
    {
        $wereDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($query = $mysqli->query("DELETE FROM Were WHERE id_serie = '$this->idSerie'")) {
            $wereDeleted = true;
        }
        $mysqli->close();
        return $wereDeleted;
    }


    public function update()
    {
        $wereEdited = false;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Were WHERE id_serie = '$this->idSerie' AND id_platform = '$this->idPlatform'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            $queryInsert = "INSERT INTO Were (id_serie, id_platform) VALUES ('$this->idSerie', '$this->idPlatform')";
            mysqli_query($mysqli, $queryInsert);
            $wereEdited = true;
        }

        $mysqli->close();
        return $wereEdited;
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Were WHERE id_serie = " . $this->idSerie);

        $itemObject = [];
        foreach ($query as $item) {
            $itemObject[] = new Were($item['id_serie'], $item['id_platform']);
        }

        $mysqli->close();
        return $itemObject;
    }
}
?>