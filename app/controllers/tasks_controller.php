<?php

class TasksController extends BaseController {

    public static function index() {
        $tasks = Tehtava::all();

        View::make('tehtava/listaus.html', array('tasks' => $tasks));
    }
    
    public static function show($id){
        $tasks = Tehtava::find($id);
        
        View::make("tehtava/esittely.html", array('tasks' => $tasks));
    }

}
