<?php

class Actor
{
    private $id;
    private $name;
    private $surname;
    private $birthdate;
    private $nationality;

    private $controller;

    public function __construct($idActor, $nameActor, $surnameActor, $birthdateActor, $nationalityActor)
    {
        $this->id = $idActor;
        $this->name = $nameActor;
        $this->surname = $surnameActor;
        $this->birthdate = $birthdateActor;
        $this->nationality = $nationalityActor;
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
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
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
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @param mixed $birthdate
     */
    public function setBirthDate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
    }

    public function getAll()
    {
        $mysqli = $this->controller->initConnectionDb();

        $query = $mysqli->query("SELECT * FROM Actors");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Actor($item['id'], $item['name'], $item['surname'], $item['birthdate'], $item['nationality']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $actorCreated = false;
        $actorRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el nombre y apellido del actor
        $queryCheck = "SELECT * FROM Actors WHERE name = '$this->name' and surname = '$this->surname'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($resultInsert = $mysqli->query("INSERT INTO Actors (name, surname, birthdate, nationality) VALUES ('$this->name','$this->surname','$this->birthdate','$this->nationality')")) {
                $actorCreated = true;
                $actorRepeated = false;
            }
        }


        $mysqli->close();
        return [$actorCreated, $actorRepeated];
    }

    public function update()
    {
        $actorEdited = false;
        $actorRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el nombre y apellido del actor
        $queryCheck = "SELECT * FROM Actors WHERE name = '$this->name' and surname = '$this->surname'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($query = $mysqli->query("UPDATE Actors set name = '" . $this->name . "', surname = '" . $this->surname . "', birthdate = '" . $this->birthdate . "', nationality = '" . $this->nationality . "' WHERE id = " . $this->id)) {
                $actorEdited = true;
                $actorRepeated = false;
            }
        }

        $mysqli->close();
        return [$actorEdited, $actorRepeated];
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Actors WHERE id = '" . $this->id . "'");

        $itemObject = null;
        foreach ($query as $item) {
            $itemObject = new Actor($item['id'], $item['name'], $item['surname'], $item['birthdate'], $item['nationality']);
            break;
        }

        $mysqli->close();
        return $itemObject;
    }

    public function delete()
    {
        $actorDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        $idActorOK = rtrim($this->id, '/');

        //se comprueba que existe el id antes de borrar
        $queryCheck = "SELECT * FROM Actors WHERE id = '$idActorOK'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) != 0) {
            if ($query = $mysqli->query("DELETE FROM  Actors WHERE id = " . $idActorOK)) {
                $actorDeleted = true;
            }
        }

        $mysqli->close();
        return $actorDeleted;
    }
}
?>