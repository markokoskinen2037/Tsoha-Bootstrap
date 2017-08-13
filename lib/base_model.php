<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
          $methodToRun = $validator;
          $errors[] = $this->{$methodToRun}();
          
          
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
      }

      return $errors;
    }
    
    public function validate_string_length($string, $length){
        $errorsInThisTest = array();
        
        if(strlen($string) > $length || strlen($string) == 0){
            $errorsInThisTest[] = "Nimen pituus ei kelpaa.";
        }
        return $errorsInThisTest;
    }
    
    public function validate_int_size($int,$maxvalue){
        if($int <= $maxvalue){
            echo "this is fine";
        } else {
            
        }
    }

  }
