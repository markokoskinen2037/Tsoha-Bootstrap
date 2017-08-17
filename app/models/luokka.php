<?php

class Luokka extends BaseModel {

    public $id, $luokkanimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $query = DB::connection()->prepare("SELECT * FROM Luokka;");
        $query->execute();
        $rows = $query->fetchAll();
        $luokat = array();
        
        foreach ($rows as $row){
            $luokat[] = new Luokka(array(
                "id" => $row["id"],
                "luokkanimi" => $row["luokkanimi"]
            ));
        }
        return $luokat;
    }
    
    public static function save(){
        $query = DB::connection()->prepare('INSERT INTO Luokka (luokkanimi) VALUES (:luokkanimi)');
        $query->execute(array("luokkanimi" => $this->luokkanimi));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

}
