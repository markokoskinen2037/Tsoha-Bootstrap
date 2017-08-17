<?php

class TasksController extends BaseController {

    public static function index() {

        if (isset($_SESSION['user'])) {
            $tasks = Tehtava::findUsersTasks($_SESSION['user']);
        } else {
            $tasks = Tehtava::all();
        }
        View::make('tehtava/listaus.html', array('tasks' => $tasks));
    }

    public static function show($id) {
        $task = Tehtava::find($id);
        View::make('tehtava/esittely.html', array('taskdata' => $task));
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            "tehtavanimi" => $params["nimi"],
            "kuvaus" => $params["kuvaus"],
            "luokkatunnus" => $params["luokkatunnus"],
            "tarkeysaste" => $params["tarkeysaste"]
        );

        $tehtava = new Tehtava($attributes);
        $errors = $tehtava->errors();


        if (count($errors) == 0) {
            $tehtava->save();
            Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtävä lisätty!'));
        } else {
            View::make('tehtava/uusi.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function create() {
        View::make('tehtava/uusi.html', array('luokat' => Luokka::all()));
    }

    public static function edit($id) {
        $tehtava = Tehtava::find($id);
        View::make("tehtava/muokkaus.html", array("attributes" => $tehtava, "luokat" => Luokka::all()));
    }

    public static function markAsDone($id) {
        $params = $_POST;
        $tehtava = Tehtava::find($id);
        $totuusarvo = null;
        
        if($tehtava->tehty == "t"){
            $totuusarvo = "f";
        } else {
            $totuusarvo = "t";
        }

        
        
        $attributes = array(
            "tehtavanimi" => $tehtava->tehtavanimi,
            "kuvaus" => $tehtava->kuvaus,
            "tehty" => $totuusarvo,
            "luokkatunnus" => $tehtava->luokkatunnus,
            "tarkeysaste" => $tehtava->tarkeysaste
        );
        
        $uusitehtava = new Tehtava($attributes);
        $uusitehtava->update($id);
        

        Redirect::to("/tehtava");
    }

    public static function update($id) {
        $params = $_POST;

        if (isset($params['laatikko'])) {
            $tehty = "t";
        } else {
            $tehty = "f";
        }




        $attributes = array(
            "tehtavanimi" => $params["tehtavanimi"],
            "kuvaus" => $params["kuvaus"],
            "tehty" => $tehty,
            "luokkatunnus" => $params["luokkatunnus"],
            "tarkeysaste" => $params["tarkeysaste"]
        );

        $tehtava = new Tehtava($attributes);
        $errors = $tehtava->errors();

        if (count($errors) > 0) {
            View::make("tehtava/muokkaus.html", array("errors" => $errors, "attributes" => $attributes));
        } else {
            $tehtava->update($id);
            Redirect::to("/tehtava/" . $id, array("message" => "Muokkaukset tallennettu."));
        }
    }

    public static function destroy($id) {
        $tehtava = new Tehtava(array("id" => $id));

        $tehtava->destroy();

        Redirect::to("/tehtava", array("message" => "Tehtava poistettu."));
    }

}
