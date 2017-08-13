<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();

        foreach ($this->validators as $validator) {
            $methodToRun = $validator;
            $returnedArray = $this->{$methodToRun}();
            
            if($returnedArray != null){
                $errors = array_merge($errors, $returnedArray);
            }
            
            
            
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        }
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $validation_errors = array();
        
        if($length == 100){ //Tiedetään että tarkastellaan nimeä
            if(strlen($string) > 100){
                $validation_errors[] = "Nimi on liian pitkä.";
            }
            if($string == null){
                $validation_errors[] = "Nimi ei voi olla null.";
            }
        }
        
        if($length == 500){ //Tiedetään että tarkastellaan kuvausta
            if(strlen($string) > 500){
                $validation_errors[] = "Kuvaus on liian pitkä.";
            }
        }
        
        
        return $validation_errors;
    }

    public function validate_int_value($int, $maxvalue) {
        $validation_errors = array();
        
        if($int > $maxvalue){
            $validation_errors[] = "Liian suuri numeroarvo.";
        }
        
        return $validation_errors;
    }

}
