<?php

class Have
{
    private $idSerie;
    private $idDirector;

    private $controller;

    public function __construct($id_serie, $id_director)
    {
        $this->idSerie = $id_serie;
        $this->idDirector = $id_director;
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
    public function getIdDirector()
    {
        return $this->idDirector;
    }

    /**
     * @param mixed $idSerie
     */
    public function setIdSerie($idSerie)
    {
        $this->idSerie = $idSerie;
    }

    /**
     * @param mixed $idDirector
     */
    public function setIdDirector($idDirector)
    {
        $this->idDirector = $idDirector;
    }

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Have");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Have($item['id_serieH'], $item['id_director']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $haveCreated = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($resultInsert = $mysqli->query("INSERT INTO Have (id_serieH, id_director) VALUES ('$this->idSerie','$this->idDirector')")) {
            $haveCreated = true;
        }

        $mysqli->close();
        return $haveCreated;
    }

    public function delete()
    {
        $haveDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($query = $mysqli->query("DELETE FROM Have WHERE id_serieH = '$this->idSerie'")) {
            $haveDeleted = true;
        }
        $mysqli->close();
        return $haveDeleted;
    }

    public function update()
    {
        $haveEdited = false;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Have WHERE id_serieH = '$this->idSerie' AND id_director = '$this->idDirector'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            $queryInsert = "INSERT INTO Have (id_serieH, id_director) VALUES ('$this->idSerie', '$this->idDirector')";
            mysqli_query($mysqli, $queryInsert);
            $haveEdited = true;
        }

        $mysqli->close();
        return $haveEdited;
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Have WHERE id_serieH = " . $this->idSerie);

        $itemObject = [];
        foreach ($query as $item) {
            $itemObject[] = new Have($item['id_serieH'], $item['id_director']);
        }

        $mysqli->close();
        return $itemObject;
    }
}
?>