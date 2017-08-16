<?php

class UserController extends BaseController {

    public static function login() {
        View::make("kayttaja/kirjautuminen.html");
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['kirjautumisnimi'], $params['salasana']);

        if (!$user) {
            View::make('kayttaja/kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kirjautumisnimi' => $params['kirjautumisnimi']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->salasana . '!'));
        }
    }

}
