<?php

class Tehtava extends BaseModel {

    public $id, $tehtavanimi, $kuvaus, $tehty, $luomisaika;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Tehtava");
        $query->execute();
        $rows = $query->fetchAll();
        $tehtavat = array();

        foreach ($rows as $row) {
            $tehtavat[] = new Tehtava(array(
                "id" => $row["id"],
                "tehtavanimi" => $row["tehtavanimi"],
                "kuvaus" => $row["kuvaus"],
                "tehty" => $row["tehty"],
                "luomisaika" => $row["luomisaika"],
            ));
        }

        return $tehtavat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tehtava WHERE id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();

        if ($row) {
            $tehtava = new Tehtava(array(
                "id" => $row["id"],
                "tehtavanimi" => $row["tehtavanimi"],
                "kuvaus" => $row["kuvaus"],
                "tehty" => $row["tehty"],
                "luomisaika" => $row["luomisaika"]
            ));
            return $tehtava;
        }
        return null;
    }

}
