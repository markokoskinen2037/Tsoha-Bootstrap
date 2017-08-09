<?php

class TaskController extends BaseController{
    
    public static function index(){
        $tasks = tehtava::all();
        
        View::make('suunnitelmat/listaus.html', array('tasks' => $tasks));
        
        
    }
}
