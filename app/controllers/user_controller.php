<?php

class UserController extends BaseController {

    public static function login() {
        View::make("kayttaja/kirjautuminen.html");
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('kayttaja/kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->name . '!'));
        }
    }

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Kayttaja WHERE kirjautumisnimi = :kirjautumisnimi AND salasana = :salasana LIMIT 1');
        $query->execute(array('kirjautumisnimi' => $username, 'salasana' => $password));
        $row = $query->fetch();
        if ($row) {
            return new User($username,$salasana);
        } else {
            return null;
        }
    }

}
