<?php

class Serie
{
    private $id;
    private $title;

    private $controller;

    public function __construct($idSerie, $titleSerie)
    {
        $this->id = $idSerie;
        $this->title = $titleSerie;
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
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Series");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Serie($item['id'], $item['title']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $serieCreated = false;
        $nameRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el titulo de la serie
        $queryCheck = "SELECT * FROM Series WHERE title = '$this->title'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($resultInsert = $mysqli->query("INSERT INTO Series (title) VALUES ('$this->title')")) {
                $serieCreated = true;
                $nameRepeated = false;

                $query = $mysqli->query("SELECT * FROM Series WHERE title = '$this->title'");
                $listData = [];

                foreach ($query as $item) {
                    $itemObject = new Serie($item['id'], $item['title']);
                    array_push($listData, $itemObject);
                }
                $serieId = $listData[0]->getId();
            }
        }


        $mysqli->close();
        return [$serieCreated, $serieId, $nameRepeated];
    }

    public function update()
    {
        $serieEdited = false;
        $nameRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el titulo de la serie
        $queryCheck = "SELECT * FROM Series WHERE title = '$this->title'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($query = $mysqli->query("UPDATE Series set title = '" . $this->title . "' WHERE id = " . $this->id)) {
                $serieEdited = true;
                $nameRepeated = false;
            }
        }

        $queryCheck2 = "SELECT * FROM Series WHERE title = '$this->title' AND id = '$this->id'";
        $resultCheck2 = mysqli_query($mysqli, $queryCheck2);
        if (mysqli_num_rows($resultCheck2) == 1) {
            if ($query = $mysqli->query("UPDATE Series set title = '" . $this->title . "' WHERE id = " . $this->id)) {
                $serieEdited = true;
                $nameRepeated = false;
            }
        }

        $mysqli->close();
        return [$serieEdited, $nameRepeated];
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Series WHERE id = '" . $this->id . "'");

        $itemObject = null;
        foreach ($query as $item) {
            $itemObject = new Serie($item['id'], $item['title']);
            break;
        }

        $mysqli->close();
        return $itemObject;
    }

    public function delete()
    {
        $serieDeleted = false;
        $mysqli = $this->controller->initConnectionDb();


        $idSerieOK = rtrim($this->id, '/');

        $queryCheck = "SELECT * FROM Series WHERE id = '$idSerieOK'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) != 0) {
            if ($query = $mysqli->query("DELETE FROM  Series WHERE id = " . $idSerieOK)) {
                $serieDeleted = true;
            }
        }

        $mysqli->close();
        return $serieDeleted;
    }
}
?>