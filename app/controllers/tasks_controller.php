<?php

class TasksController extends BaseController{
    
    public static function index(){
        $tasks = Tehtava::all();
        
        View::make('suunnitelmat/tehtava/listaus.html', array('tasks' => $tasks));
        
        
    }
}
