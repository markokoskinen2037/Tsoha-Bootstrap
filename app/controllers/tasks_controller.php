<?php

class TasksController extends BaseController {

    public static function index() {
        $tasks = Tehtava::all();
        View::make('tehtava/listaus.html', array('tasks' => $tasks));
    }
    
    public static function show($id){
        $task = Tehtava::find($id);
        //Kint::dump($task);
        View::make('tehtava/esittely.html',array('taskdata' => $task));
    }
    
    public static function store(){
        $params = $_POST;
        
        $tehtava = new Tehtava(array(
            "tehtavanimi" => $params["nimi"],
            "kuvaus" => $params["kuvaus"],
            "luokkatunnus" => $params["luokkatunnus"],
            "tarkeysaste" => $params["tarkeysaste"]
        ));
        
        $tehtava->save();
        
        Redirect::to('/tehtava/' . $tehtava->id, array('message' => 'Tehtävä lisätty!'));
    }
    
    public static function create(){
        View::make('tehtava/uusi.html');
    }

}
