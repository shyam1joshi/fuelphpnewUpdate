<?php

namespace trackdevices;

class Controller_Userdevices extends \Controller_Base{
    
    public $model = "\\trackdevices\Model_Userdevices";
    public $base = "userdevices";
    public $title = "Userdevices"; 
    
    public function action_create() {
        \Response::redirect("userdevices");
    }
}