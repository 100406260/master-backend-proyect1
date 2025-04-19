<?php

class Appear
{
    private $idSerie;
    private $idActor;

    private $controller;

    public function __construct($id_serie, $id_actor)
    {
        $this->idSerie = $id_serie;
        $this->idActor = $id_actor;
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
    public function getIdActor()
    {
        return $this->idActor;
    }

    /**
     * @param mixed $idSerie
     */
    public function setIdSerie($idSerie)
    {
        $this->idSerie = $idSerie;
    }

    /**
     * @param mixed $idActor
     */
    public function setIdActor($idActor)
    {
        $this->idActor = $idActor;
    }

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Appear");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Appear($item['id_serieA'], $item['id_actor']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }


    public function store()
    {
        $appearCreated = false;
        $mysqli = $this->controller->initConnectionDb();


        if ($resultInsert = $mysqli->query("INSERT INTO Appear (id_serieA, id_actor) VALUES ('$this->idSerie','$this->idActor')")) {
            $appearCreated = true;
        }


        $mysqli->close();
        return $appearCreated;
    }

    public function delete()
    {
        $appearDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($query = $mysqli->query("DELETE FROM Appear WHERE id_serieA = '$this->idSerie'")) {
            $appearDeleted = true;
        }
        $mysqli->close();
        return $appearDeleted;
    }


    public function update()
    {
        $appearEdited = false;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Appear WHERE id_serieA = '$this->idSerie' AND id_actor = '$this->idActor'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            $queryInsert = "INSERT INTO Appear (id_serieA, id_actor) VALUES ('$this->idSerie', '$this->idActor')";
            mysqli_query($mysqli, $queryInsert);
            $appearEdited = true;
        }


        $mysqli->close();
        return $appearEdited;
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Appear WHERE id_serieA = " . $this->idSerie);

        $itemObject = [];
        foreach ($query as $item) {
            $itemObject[] = new Appear($item['id_serieA'], $item['id_actor']);
        }

        $mysqli->close();
        return $itemObject;
    }
}
?>