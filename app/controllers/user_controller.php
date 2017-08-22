<?php

class UserController extends BaseController {

    public static function login() {
        View::make("kayttaja/kirjautuminen.html");
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['kirjautumisnimi'], $params['salasana']);

        if (!$user) {
            View::make('kayttaja/kirjautuminen.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'kirjautumisnimi' => $params['kirjautumisnimi']));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->kirjautumisnimi . '!'));
        }
    }

    public static function showAdminPage() {
        View::make('kayttaja/supersecretadminpage.html');
    }

    public static function register() {
        View::make("kayttaja/rekisteroituminen.html");
    }

    public static function create() {
        $params = $_POST;

        $user = new User(array("kirjautumisnimi" => $params["kirjautumisnimi"], "salasana" => $params["salasana"]));

        $users = array();
        $users = $user->all();
        $errors = array();

        foreach ($users as $tarkasteltava) { //Kirjautumisnimen tarkistus
            if ($user->kirjautumisnimi == $tarkasteltava->kirjautumisnimi) {
                $errors[] = "Valitse toinen kirjautumisnimi!";
                View::make("kayttaja/rekisteroituminen.html", array('errors' => $errors, "nimi" => $user->kirjautumisnimi, "salasana" => $user->salasana));
            }
        }

        $errors = $user->errors();

        if ($errors == 0) {

            $user->save($params["kirjautumisnimi"], $params["salasana"]);

            View::make("kayttaja/rekisteroituminen.html", array("message" => "Tunnus luotu onnistuneesti!"));
        } else {
            View::make("kayttaja/rekisteroituminen.html", array('errors' => $errors,"nimi" => $user->kirjautumisnimi, "salasana" => $user->salasana));
        }


        //Jos loopin aikana ei törmätä samaan tunnukseen, voidaan luoda uusi
    }

}
