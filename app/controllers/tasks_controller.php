<?php

class TasksController extends BaseController{
    
    public static function index(){
        $tasks = Tehtava::all();
        
        View::make('suunnitelmat/listaus.html', array('tasks' => $tasks));
        
        
    }
}
