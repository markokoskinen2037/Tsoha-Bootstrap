<?php

class BaseController {

    public static function get_user_logged_in() {

//        return new User(array("kirjautumisnimi" => "eitoimisessionidei", "salasana" => "asdasd"));


        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];
            $user = User::find($user_id);
            return $user;
        } else {
            return null;
        }
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/kayttaja/kirjautuminen', array('message' => 'Kirjaudu ensin sisään!'));
        }
    }

}
