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

$router->get('tehtava/:id', function() {
    TasksController::show();
});
