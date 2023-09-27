<?php 

namespace dynamicformssystem;
class model{
    var $widgeter = null;
    public function __construct(
        string $name, 
        string $model, 
        module $module,
        $array
    ) {

        $this->name = $name;
        $this->model = $model;
        $this->module = $module;
        $this->settings =  $array;
    }

    public function assignWidgeter($widgeter){
        $this->widgeter=$widgeter;
    }

    public function buildFile(){

    }

    public function getWidgets(){
            

        
    }

    public function flushFile(){


    }

    public function populateSettings(){

    }

    public function buildHasOne(){


    }

    public function buildHasMany(){



    }


}