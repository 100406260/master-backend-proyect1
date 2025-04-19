<?php

class Listen
{
    private $idSerie;
    private $idAudio;

    private $controller;

    public function __construct($id_serie, $id_audio)
    {
        $this->idSerie = $id_serie;
        $this->idAudio = $id_audio;
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
    public function getIdAudio()
    {
        return $this->idAudio;
    }

    /**
     * @param mixed $idSerie
     */
    public function setIdSerie($idSerie)
    {
        $this->idSerie = $idSerie;
    }

    /**
     * @param mixed $idAudio
     */
    public function setIdAudio($idAudio)
    {
        $this->idAudio = $idAudio;
    }

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Listen");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Listen($item['id_serieL'], $item['id_audio']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $listenCreated = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($resultInsert = $mysqli->query("INSERT INTO Listen (id_serieL, id_audio) VALUES ('$this->idSerie','$this->idAudio')")) {
            $listenCreated = true;
        }

        $mysqli->close();
        return $listenCreated;
    }

    public function delete()
    {
        $listenDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        if ($query = $mysqli->query("DELETE FROM Listen WHERE id_serieL = '$this->idSerie'")) {
            $listenDeleted = true;
        }
        $mysqli->close();
        return $listenDeleted;
    }


    public function update()
    {
        $listenEdited = false;
        $mysqli = $this->controller->initConnectionDb();

        $queryCheck = "SELECT * FROM Listen WHERE id_serieL = '$this->idSerie' AND id_audio = '$this->idAudio'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);

        if (mysqli_num_rows($resultCheck) == 0) {
            $queryInsert = "INSERT INTO Listen (id_serieL, id_audio) VALUES ('$this->idSerie', '$this->idAudio')";
            mysqli_query($mysqli, $queryInsert);
            $listenEdited = true;
        }

        $mysqli->close();
        return $listenEdited;
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Listen WHERE id_serieL = " . $this->idSerie);

        $itemObject = [];
        foreach ($query as $item) {
            $itemObject[] = new Listen($item['id_serieL'], $item['id_audio']);
        }

        $mysqli->close();
        return $itemObject;
    }
}
?>