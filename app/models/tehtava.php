<?php

class Tehtava extends BaseModel {

    public $id, $tehtavanimi, $kuvaus, $tehty, $luomisaika, $luokkatunnus, $tarkeysaste, $tekija;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array("validate_tehtavanimi", "validate_kuvaus", "validate_luokkatunnus", "validate_tarkeysaste");
    }

    public static function all() { //Huom. tärkeysasteen mukainen järjestys!
        $query = DB::connection()->prepare("SELECT * FROM Tehtava ORDER BY tarkeysaste DESC;");
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
                "luokkatunnus" => $row["luokkatunnus"],
                "tarkeysaste" => $row["tarkeysaste"],
                "tekija" => $row["tekija"]
            ));
        }

        return $tehtavat;
    }

    public static function findUsersTasks($tekija_id) {
        $query = DB::connection()->prepare("SELECT * FROM Tehtava WHERE tekija = :id ORDER BY tarkeysaste DESC");
        $query->execute(array("id" => $tekija_id));
        $rows = $query->fetchAll();
        $tehtavat = array();

        foreach ($rows as $row) {
            $tehtavat[] = new Tehtava(array(
                "id" => $row["id"],
                "tehtavanimi" => $row["tehtavanimi"],
                "kuvaus" => $row["kuvaus"],
                "tehty" => $row["tehty"],
                "luomisaika" => $row["luomisaika"],
                "luokkatunnus" => $row["luokkatunnus"],
                "tarkeysaste" => $row["tarkeysaste"],
                "tekija" => $row["tekija"]
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
                "luomisaika" => $row["luomisaika"],
                "luokkatunnus" => $row["luokkatunnus"],
                "tarkeysaste" => $row["tarkeysaste"],
                "tekija" => $row["tekija"]
            ));
            return $tehtava;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtava (tehtavanimi,kuvaus,luomisaika,luokkatunnus,tarkeysaste,tekija) VALUES (:tehtavanimi, :kuvaus, Now(), :luokkatunnus, :tarkeysaste, :tekija) RETURNING id');
        $query->execute(array('tehtavanimi' => $this->tehtavanimi, 'kuvaus' => $this->kuvaus, 'luokkatunnus' => $this->luokkatunnus, 'tarkeysaste' => $this->tarkeysaste, 'tekija' => $_SESSION['user']));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    //("validate_tehtavanimi", "validate_kuvaus", "validate_luokkatunnus", "validate_tarkeysaste");

    public function validate_tehtavanimi() {
        return $this->validate_string_length($this->tehtavanimi, 100);
    }

    public function validate_kuvaus() {
        return $this->validate_string_length($this->kuvaus, 500);
    }

    public function validate_luokkatunnus() {
        return $this->validate_int_value($this->luokkatunnus, len(Tehtava::all())); //2 on vain placeholder arvo
    }

    public function validate_tarkeysaste() {
        return $this->validate_int_value($this->tarkeysaste, 5);
    }

    public function update($id) {


        $query = DB::connection()->prepare('UPDATE Tehtava SET tehtavanimi=:tehtavanimi,kuvaus=:kuvaus,tehty=:tehty,luokkatunnus=:luokkatunnus,tarkeysaste=:tarkeysaste WHERE id=:id;');
        $query->execute(array('tehtavanimi' => $this->tehtavanimi, 'kuvaus' => $this->kuvaus, 'tehty' => $this->tehty, 'luokkatunnus' => $this->luokkatunnus, 'tarkeysaste' => $this->tarkeysaste, 'id' => $id));
    }

    public function destroy() {

        $query1 = DB::connection()->prepare('DELETE FROM Tehtavaluokka WHERE tehtavaid=:id;');
        $query1->execute(array("id" => $this->id));


        $query2 = DB::connection()->prepare('DELETE FROM Tehtava WHERE Tehtava.id=:id;');
        $query2->execute(array("id" => $this->id));
    }

}
