<?php

class HelloWorldController extends BaseController {

    public static function index() {
        View::make('suunnitelmat/etusivu.html');
    }

    public static function sandbox() {

        Kint::dump($_SESSION['user']);
    }

    public static function esittely() {
        View::make("tehtava/esittely.html");
    }

    public static function kirjautuminen() {
        View::make("kayttaja/kirjautuminen.html");
    }

    public static function listaus() {
        View::make("tehtava/listaus.html");
    }

    public static function muokkaus() {
        View::make("tehtava/muokkaus.html");
    }

}
