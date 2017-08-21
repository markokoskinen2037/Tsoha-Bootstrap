<?php

class Luokka extends BaseModel {

    public $id, $luokkanimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array("validate_luokkanimi");
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Luokka;");
        $query->execute();
        $rows = $query->fetchAll();
        $luokat = array();

        foreach ($rows as $row) {
            $luokat[] = new Luokka(array(
                "id" => $row["id"],
                "luokkanimi" => $row["luokkanimi"]
            ));
        }
        return $luokat;
    }

    public static function save($luokkanimi) {
        $query = DB::connection()->prepare('INSERT INTO Luokka (luokkanimi) VALUES (:luokkanimi)');
        $query->execute(array("luokkanimi" => $luokkanimi));
    }

    public function validate_luokkanimi() {
        return $this->validate_string_length($this->luokkanimi, 100);
    }

    public static function destroy($id) {
        $query = DB::connection()->prepare('DELETE FROM Luokka WHERE id=:id');
        $query->execute(array("id" => $id));
    }

}
