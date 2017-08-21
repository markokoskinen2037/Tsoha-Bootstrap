<?php

$routes->get('/', function() {
    HelloWorldController::index();
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/esittely', function() {
    HelloWorldController::esittely();
});

$routes->get('/kirjautuminen', function() {
    HelloWorldController::kirjautuminen();
});

$routes->get('/muokkaus', function() {
    HelloWorldController::muokkaus();
});

$routes->get('/tehtava', function() { //Listaa kaikki kirjautuneen käyttäjän tehtävät
    TasksController::index();
});

$routes->get('/tehtava/uusi', function() {
    TasksController::create();
});

$routes->get('/tehtava/:id', function($id) {
    TasksController::show($id);
});

$routes->get('/tehtava/:id/muokkaus', function($id) {
    TasksController::edit($id);
});

$routes->post('/tehtava/:id/muokkaus', function($id) {
    TasksController::update($id);
});

$routes->post('/tehtava/:id/poista', function($id) {
    TasksController::destroy($id);
});

$routes->post('/tehtava/:id/tehty', function($id) {
    TasksController::markAsDone($id);
});

$routes->post('/tehtava', function() {
    TasksController::store();
});

$routes->post('/supersecretadminpage', function() {
    TasksController::deleteAllTasks();
});

$routes->get('/luokka/uusi', function() {
    LuokkaController::create();
});

$routes->post('/luokka', function() {
    LuokkaController::store();
});

$routes->post('/luokka/poista', function() {
    LuokkaController::destroy();
});

$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/supersecretadminpage', function() {
    UserController::showAdminPage();
});

$routes->post('/logout', function() {
    UserController::logout();
});

$routes->get('/register', function() {
    UserController::logout();
});

$routes->post('/register', function() {
    UserController::logout();
    //git commit testi
});
