<?php

class LuokkaController extends BaseController {

    public static function create() {
        View::make("luokka/uusi.html", array("luokat" => Luokka::all()));
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
            Redirect::to("/luokka/uusi", array('message' => "Luokka lisätty onnistuneesti!"));
        } else {
            Redirect::to("/luokka/uusi", array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function destroy() {
        $params = $_POST;
        $luokka = new Luokka(array("id" => $params["luokkatunnus"]));


        $luokka->destroy($params["luokkatunnus"]);


        Redirect::to("/luokka", array("message" => "Luokka poistettu."));
    }

}
