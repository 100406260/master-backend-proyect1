<?php

class Leer
{
    private $idSerie;
    private $idSub;

    private $controller;

    public function __construct($id_serie, $id_sub)
    {
        $this->idSerie = $id_serie;
        $this->idSub = $id_sub;
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
    public function getIdSub()
    {
        return $this->idSub;
    }

    /**
     * @param mixed $idSerie
     */
    public function setIdSerie($idSerie)
    {
        $this->idSerie = $idSerie;
    }

    /**
     * @param mixed $idSub
     */
    public function setIdSub($idSub)
    {
        $this->idSub = $idSub;
    }

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Leer");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Leer($item['id_serieR'], $item['id_sub']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $leerCreated = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($resultInsert = $mysqli->query("INSERT INTO Leer (id_serieR, id_sub) VALUES ('$this->idSerie','$this->idSub')")) {
            $leerCreated = true;
        }

        $mysqli->close();
        return $leerCreated;
    }

    public function delete()
    {
        $leerDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($query = $mysqli->query("DELETE FROM Leer WHERE id_serieR = '$this->idSerie'")) {
            $leerDeleted = true;
        }
        $mysqli->close();
        return $leerDeleted;
    }


    public function update()
    {
        $leerEdited = false;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Leer WHERE id_serieR = '$this->idSerie' AND id_sub = '$this->idSub'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            $queryInsert = "INSERT INTO Leer (id_serieR, id_sub) VALUES ('$this->idSerie', '$this->idSub')";
            mysqli_query($mysqli, $queryInsert);
            $leerEdited = true;
        }

        $mysqli->close();
        return $leerEdited;
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Leer WHERE id_serieR = " . $this->idSerie);

        $itemObject = [];
        foreach ($query as $item) {
            $itemObject[] = new Leer($item['id_serieR'], $item['id_sub']);
        }

        $mysqli->close();
        return $itemObject;
    }
}
?>