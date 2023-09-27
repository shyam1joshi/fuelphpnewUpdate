<?php

namespace dynamicformssystem;

class Controller_Pastform extends \Controller_Base{
    
    function before(){
        echo "killed at before";
        die();
    }
        
    
    //List all forms , from the forms table 
    //Use standard listing of forms data 
    
   function  action_index(){
        
        die();
    }
    
    //Click the view to render the form
    
} 
