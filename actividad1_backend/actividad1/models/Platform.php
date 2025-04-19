<?php

class Platform
{
    private $id;
    private $name;

    private $controller;

    public function __construct($idPlatform, $namePlatform)
    {
        $this->id = $idPlatform;
        $this->name = $namePlatform;
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

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Platforms");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Platform($item['id'], $item['name']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $platformCreated = false;
        $nameRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el nombre de la plataforma
        $queryCheck = "SELECT * FROM Platforms WHERE name = '$this->name'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($resultInsert = $mysqli->query("INSERT INTO Platforms (name) VALUES ('$this->name')")) {
                $platformCreated = true;
                $nameRepeated = false;
            }
        }


        $mysqli->close();
        return [$platformCreated, $nameRepeated];
    }

    public function update()
    {
        $platformEdited = false;
        $nameRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el nombre de la plataforma
        $queryCheck = "SELECT * FROM Platforms WHERE name = '$this->name'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($query = $mysqli->query("UPDATE Platforms SET name = '" . $this->name . "' WHERE id = " . $this->id)) {
                $platformEdited = true;
                $nameRepeated = false;
            }
        }

        $mysqli->close();
        return [$platformEdited, $nameRepeated];
    }


    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Platforms WHERE id = '" . $this->id . "'");

        $itemObject = null;
        foreach ($query as $item) {
            $itemObject = new Platform($item['id'], $item['name']);
            break;
        }

        $mysqli->close();
        return $itemObject;
    }

    public function delete()
    {
        $platformDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        $idPlatformOK = rtrim($this->id, '/');

        //se comprueba que existe el id antes de borrar
        $queryCheck = "SELECT * FROM Platforms WHERE id = '$idPlatformOK'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) != 0) {
            if ($query = $mysqli->query("DELETE FROM  Platforms WHERE id = " . $idPlatformOK)) {
                $platformDeleted = true;
            }
        }

        $mysqli->close();
        return $platformDeleted;
    }
}
?>