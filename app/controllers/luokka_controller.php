<?php

class LuokkaController extends BaseController{
    
    public static function create(){
        View::make("luokka/uusi.html");
    }
    
    public static function store(){
        $params = $_POST;
        
        $attributes = array(
            "luokkanimi" => $params["luokkanimi"]
        );
        
        $luokka = new Luokka($attributes);
        $luokka->save();
    }
    
    
}