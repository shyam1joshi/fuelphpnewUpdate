<?php 

namespace dynamicformssystem;
class lang{
    
            public function __construct(
                    $name, 
                    $model, 
                    $module,
                    $array
            ) {

            $this->name = $name;

            $this->model = $model;

            $this->module = $module;
            $this->settings =  $array;
            $this->controllerName = \Inflector::classify($this->name);

            }

            function getLangFromPost(){



            }
            function compileLangFile(){



                
            }

            function pushLangFile(){


            }


        }