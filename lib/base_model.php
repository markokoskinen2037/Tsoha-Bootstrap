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

            if ($returnedArray != null) {
                $errors = array_merge($errors, $returnedArray);
            }



            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
        }
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $validation_errors = array();

        if (strlen($string) > $length) {
            $validation_errors[] = "Liian pitkä merkkijono";
        }

        if ($string == null) {
            $validation_errors[] = "Ole hyvä ja älä jätä mitään kenttää tyhjäksi.";
        }


        return $validation_errors;
    }

    public function validate_int_value($int, $maxvalue) {
        $validation_errors = array();

        if ($int > $maxvalue) {
            $validation_errors[] = "Liian suuri numeroarvo.";
        }

        if (!ctype_digit(strval($int))) {
            $validation_errors[] = "Ole hyvä ja syötä numeroarvo.";
        }

        if ($int == null) {
            $validation_errors[] = "Älä jätä mitään kenttää tyhjäksi.";
        }

        return $validation_errors;
    }

}
