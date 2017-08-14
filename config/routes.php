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

$routes->get('/listaus', function() {
    HelloWorldController::listaus();
});

$routes->get('/muokkaus', function() {
    HelloWorldController::muokkaus();
});

$routes->get('/tehtava', function() {
    TasksController::index();
});

$routes->get('/tehtava/uusi', function() {
    TasksController::create();
});

$routes->get('/tehtava/:id', function($id) {
    TasksController::show($id);
});

$routes->get('/tehtava/:id/muokkaus', function($id){
    TasksController::edit($id);
});

$routes->post('/tehtava/:id/muokkaus', function($id){
    TasksController::update($id);
});

$routes->post('/tehtava/:id/poista', function($id){
    TasksController::destroy($id);
});

$routes->post('/tehtava', function() {
    TasksController::store();
});

