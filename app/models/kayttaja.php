<?php

class Kayttaja extends BaseModel {
    
    public $id, $kirjautumisnimi, $salasana, $admin;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function save(){
        $query = DB::connection()->prepare('INSERT INTO Kayttaja (kirjautumisnimi,salasana) VALUES (:kirjautumisnimi,:salasana) RETURNING id');
        
        $query->execute(array('kirjautumisnimi' => $this->kirjautumisnimi, 'salasana' => $this->salasana));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    
    
    

    
    
    
}