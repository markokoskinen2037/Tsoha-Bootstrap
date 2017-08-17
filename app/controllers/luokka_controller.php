<?php

class LuokkaController extends BaseController {

    public static function create() {
        View::make("luokka/uusi.html");
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            "luokkanimi" => $params["luokkanimi"]
        );

        $luokka = new Luokka($attributes);
        $errors = $luokka->errors();

        if (count($errors) == 0) {
            $luokka->save($params["luokkanimi"]);
            Redirect::to("/luokka/uusi.html", array('message' => "Luokka lisätty onnistuneesti!"));
        } else {
            $luokka->save($params["luokkanimi"]);
            Redirect::to("/luokka/uusi.html", array('errors' => "$errors", 'attributes' => $attributes));
        }
    }

}
