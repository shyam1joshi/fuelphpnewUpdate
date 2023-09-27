<?php 

namespace dynamicformssystem;
class config{
        var $basepath = null;
        var $config =array();
    
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
            $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules';
            $this->controllerName = \Inflector::classify($this->name);

            }

            function getPostConfig(){

            }

            function populateSettings($config){
                $config = array();

                $data = \Input::post();
                print_r($data);die();

                if(array_key_exists("lines",$data))
                {
                        $config["connectedMods"] = $data["lines"];     
                }
                if(array_key_exists("agents",$data))
                {
                        $config["agentModel"] = $data["agents"];     
                }


                $data = var_export( $config,true );
                $this->config = $data;
            }

            function extraConfig(){


            }

            function compileConfig(){
                    $file =$this->basepath.DS.$this->module->name.DS."config/"."config.php";
                if(file_exists($file)) \File::delete($file);

              \File::create($this->basepath.DS.$this->module->name.DS."config/","config.php","<?php \n return ".$this->config.";");
            }

            function pushConfig(){

            }



    
}