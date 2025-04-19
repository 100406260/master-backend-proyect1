<?php

class Director
{
    private $id;
    private $name;
    private $surname;
    private $birthdate;
    private $nationality;

    private $controller;

    public function __construct($idDirector, $nameDirector, $surnameDirector, $birthdateDirector, $nationalityDirector)
    {
        $this->id = $idDirector;
        $this->name = $nameDirector;
        $this->surname = $surnameDirector;
        $this->birthdate = $birthdateDirector;
        $this->nationality = $nationalityDirector;
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

        $query = $mysqli->query("SELECT * FROM Directors");
        $listData = [];

        foreach ($query as $item) {
            $itemObject = new Director($item['id'], $item['name'], $item['surname'], $item['birthdate'], $item['nationality']);
            array_push($listData, $itemObject);
        }

        $mysqli->close();

        return $listData;
    }

    public function store()
    {
        $directorCreated = false;
        $directorRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el nombre y apellido del director
        $queryCheck = "SELECT * FROM Directors WHERE name = '$this->name' and surname = '$this->surname'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($resultInsert = $mysqli->query("INSERT INTO Directors (name, surname, birthdate, nationality) VALUES ('$this->name','$this->surname','$this->birthdate','$this->nationality')")) {
                $directorCreated = true;
                $directorRepeated = false;
            }
        }


        $mysqli->close();
        return [$directorCreated, $directorRepeated];
    }

    public function update()
    {
        $directorEdited = false;
        $directorRepeated = true;
        $mysqli = $this->controller->initConnectionDb();

        //se comprueba que no este repetido el nombre y apellido del director
        $queryCheck = "SELECT * FROM Directors WHERE name = '$this->name' and surname = '$this->surname'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if (mysqli_num_rows($resultCheck) == 0) {
            if ($query = $mysqli->query("UPDATE Directors set name = '" . $this->name . "', surname = '" . $this->surname . "', birthdate = '" . $this->birthdate . "', nationality = '" . $this->nationality . "' WHERE id = " . $this->id)) {
                $directorEdited = true;
                $directorRepeated = false;
            }
        }

        $mysqli->close();
        return [$directorEdited, $directorRepeated];
    }

    public function getItem()
    {
        $mysqli = $this->controller->initConnectionDb();
        $query = $mysqli->query("SELECT * FROM Directors WHERE id = '" . $this->id . "'");

        $itemObject = null;
        foreach ($query as $item) {
            $itemObject = new Director($item['id'], $item['name'], $item['surname'], $item['birthdate'], $item['nationality']);
            break;
        }

        $mysqli->close();
        return $itemObject;
    }

    public function delete()
    {
        $directorDeleted = false;
        $mysqli = $this->controller->initConnectionDb();

        $idDirectorOK = rtrim($this->id, '/');
        //se comprueba que existe el id antes de borrar
        $queryCheck = "SELECT * FROM Directors WHERE id = '$idDirectorOK'";
        $resultCheck = mysqli_query($mysqli, $queryCheck);
        if ($query = $mysqli->query("DELETE FROM  Directors WHERE id = " . $idDirectorOK)) {
            $directorDeleted = true;
        }

        $mysqli->close();
        return $directorDeleted;
    }
}
?>