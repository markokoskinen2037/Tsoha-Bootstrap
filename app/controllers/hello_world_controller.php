<?php

class HelloWorldController extends BaseController {

    public static function index() {
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('suunnitelmat/etusivu.html');
    }

    public static function sandbox() {

        $tehtava = new Tehtava(array(
            'tehtavanimi' => '',
            'kuvaus' => 'heheheheh',
            'luomisaika' => 'Now()',
            'luokkatunnus' => '1',
            'tarkeysaste' => '2'
        ));
        $errors = $tehtava->errors();

        Kint::dump($errors);


        // Testaa koodiasi täällä
//        $tehtava = Tehtava::find(1);
//        $tehtavat = Tehtava::all();
//        
//        Kint::dump($tehtavat);
//        Kint::dump($tehtava);
//        View::make('helloworld.html');
    }

    public static function esittely() {
        View::make("tehtava/esittely.html");
    }

    public static function kirjautuminen() {
        View::make("suunnitelmat/kirjautuminen.html");
    }

    public static function listaus() {
        View::make("tehtava/listaus.html");
    }

    public static function muokkaus() {
        View::make("tehtava/muokkaus.html");
    }

}
