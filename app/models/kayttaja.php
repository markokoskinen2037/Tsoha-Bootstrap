<?php

class User extends BaseModel {

    public $id, $kirjautumisnimi, $salasana, $admin;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Kayttaha WHERE id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();

        if ($row) {
            $kayttaja = new Tehtava(array(
                "id" => $row["id"],
                "kirjautumisnimi" => $row["kirjautumisnimi"],
                "salasana" => $row["salasana"],
                "admin" => $row["admin"],
            ));
            return $kayttaja;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (kirjautumisnimi,salasana) VALUES (:kirjautumisnimi,:salasana) RETURNING id');

        $query->execute(array('kirjautumisnimi' => $this->kirjautumisnimi, 'salasana' => $this->salasana));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public static function authenticate($kirjautumisnimi, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kirjautumisnimi = :kirjautumisnimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('kirjautumisnimi' => $kirjautumisnimi, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            return new User(array("kirjautumisnimi" => $kirjautumisnimi, "salasana" => $salasana));
        } else {
            return null;
        }
    }

}
