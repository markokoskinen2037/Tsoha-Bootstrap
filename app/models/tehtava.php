<?php

class Tehtava extends BaseModel {

    public $id, $tehtavanimi, $kuvaus, $tehty, $luomisaika, $luokkatunnus, $tarkeysaste, $tekija, $kirjallinenTarkeysaste;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array("validate_tehtavanimi", "validate_kuvaus", "validate_tarkeysaste");
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

            $alkuperainenLuomisaika = $row["luomisaika"]; // esim. 2017-08-22 16:02:44.343918
            $explodedLuomisaika = explode(".", $alkuperainenLuomisaika)[0]; //// esim. 2017-08-22 16:02:44
            $muokattuLuomisaika = str_ireplace("-", ".", $explodedLuomisaika);

            if ($row["tarkeysaste"] == 1) {
                $kirjallinenTarkeysaste = "Kiireetön";
            } else if ($row["tarkeysaste"] == 2) {
                $kirjallinenTarkeysaste = "Hieman kiireellinen";
            } else if ($row["tarkeysaste"] == 3) {
                $kirjallinenTarkeysaste = "Aika kiireellinen";
            } else if ($row["tarkeysaste"] == 4) {
                $kirjallinenTarkeysaste = "Hyvin kiireinen";
            } else if ($row["tarkeysaste"] == 5) {
                $kirjallinenTarkeysaste = "Äärimmäisen kiireellinen";
            }



            $tehtavat[] = new Tehtava(array(
                "id" => $row["id"],
                "tehtavanimi" => $row["tehtavanimi"],
                "kuvaus" => $row["kuvaus"],
                "tehty" => $row["tehty"],
                "luomisaika" => $muokattuLuomisaika,
                "luokkatunnus" => $row["luokkatunnus"],
                "tarkeysaste" => $row["tarkeysaste"],
                "kirjallinenTarkeysaste" => $kirjallinenTarkeysaste,
                "tekija" => $row["tekija"]
            ));
        }
        return $tehtavat;
    }

    public static function find($id) {
        $query = DB::connection()->prepare("SELECT * FROM Tehtava WHERE id = :id LIMIT 1");
        $query->execute(array("id" => $id));
        $row = $query->fetch();

        if ($row["tarkeysaste"] == 1) {
            $kirjallinenTarkeysaste = "Kiireetön";
        } else if ($row["tarkeysaste"] == 2) {
            $kirjallinenTarkeysaste = "Hieman kiireellinen";
        } else if ($row["tarkeysaste"] == 3) {
            $kirjallinenTarkeysaste = "Aika kiireellinen";
        } else if ($row["tarkeysaste"] == 4) {
            $kirjallinenTarkeysaste = "Hyvin kiireinen";
        } else if ($row["tarkeysaste"] == 5) {
            $kirjallinenTarkeysaste = "Äärimmäisen kiireellinen";
        }




        if ($row) {
            $tehtava = new Tehtava(array(
                "id" => $row["id"],
                "tehtavanimi" => $row["tehtavanimi"],
                "kuvaus" => $row["kuvaus"],
                "tehty" => $row["tehty"],
                "luomisaika" => $row["luomisaika"],
                "luokkatunnus" => $row["luokkatunnus"],
                "kirjallinenTarkeysaste" => $kirjallinenTarkeysaste,
                "tarkeysaste" => $row["tarkeysaste"],
                "tekija" => $row["tekija"]
            ));
            return $tehtava;
        }
        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Tehtava (tehtavanimi,kuvaus,luomisaika,luokkatunnus,tarkeysaste,tekija) VALUES (:tehtavanimi, :kuvaus, Now(), :luokkatunnus, :tarkeysaste, :tekija) RETURNING id');
        $query->execute(array('tehtavanimi' => $this->tehtavanimi, 'kuvaus' => $this->kuvaus, 'luokkatunnus' => $this->luokkatunnus[0], 'tarkeysaste' => $this->tarkeysaste, 'tekija' => $_SESSION['user']));
        $row = $query->fetch();
        $this->id = $row['id'];


        foreach ($this->luokkatunnus as $tunnus) { //Lisää tietokantaan tehtävä-luokka parit
            $query2 = DB::connection()->prepare('INSERT INTO TehtavaLuokka (tehtavaid,luokkaid) VALUES (:tehtavaid,:luokkaid)');
            $query2->execute(array('tehtavaid' => $this->id, "luokkaid" => $tunnus));
        }
    }

    //("validate_tehtavanimi", "validate_kuvaus", "validate_luokkatunnus", "validate_tarkeysaste");

    public function validate_tehtavanimi() {
        return $this->validate_string_length($this->tehtavanimi, 100, "tehtavanimi");
    }

    public function validate_kuvaus() {
        return $this->validate_string_length($this->kuvaus, 500, "kuvaus");
    }

    public function validate_luokkatunnus() {
        return $this->validate_int_value($this->luokkatunnus, count(Luokka::all()));
    }

    public function validate_tarkeysaste() {
        return $this->validate_int_value($this->tarkeysaste, 5);
    }

    public function update($id) {

        $placeholderLuokka = new Luokka(array());
        $luokat = $placeholderLuokka->getTasksClasses($id);



        if (in_array($this->luokkatunnus, $luokat)) { //Jos tehtävällä on jo lisättävä luokka, ei tehdä muutoksia luokkiin.
            $query = DB::connection()->prepare('UPDATE Tehtava SET tehtavanimi=:tehtavanimi,kuvaus=:kuvaus,tehty=:tehty,luokkatunnus=:luokkatunnus,tarkeysaste=:tarkeysaste WHERE id=:id;');
            $query->execute(array('tehtavanimi' => $this->tehtavanimi, 'kuvaus' => $this->kuvaus, 'tehty' => $this->tehty, 'luokkatunnus' => $this->luokkatunnus, 'tarkeysaste' => $this->tarkeysaste, 'id' => $id));
        } else { //Täytyy lisäksi luoda uusi TehtavaLuokka merkintä
            $query = DB::connection()->prepare('UPDATE Tehtava SET tehtavanimi=:tehtavanimi,kuvaus=:kuvaus,tehty=:tehty,luokkatunnus=:luokkatunnus,tarkeysaste=:tarkeysaste WHERE id=:id;');
            $query->execute(array('tehtavanimi' => $this->tehtavanimi, 'kuvaus' => $this->kuvaus, 'tehty' => $this->tehty, 'luokkatunnus' => $this->luokkatunnus, 'tarkeysaste' => $this->tarkeysaste, 'id' => $id));

            $query2 = DB::connection()->prepare("INSERT INTO TehtavaLuokka (tehtavaid,luokkaid) VALUES (:tehtavaid,:luokkaid);");
            $query2->execute(array("tehtavaid" => $id, "luokkaid" => $this->luokkatunnus));
        }
    }
    
    public function merkitsetehdyksi($id){
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
