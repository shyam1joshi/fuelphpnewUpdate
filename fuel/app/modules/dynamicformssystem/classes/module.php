<?php

namespace dynamicformssystem;
class module{
    var  $controllers = null;
    var  $model = null;
    var  $widgeter = null;

    public function __construct(
         $name,
        $array
    ) {
        $this->name = $name;
        $this->settings =  $array;
        $this->basepath = APPPATH.'modules'.DS.'dynamicformssystem'.DS.'modules';
    }

    public function buildControllers(){
           $controller = new \dynamicformssystem\Controller($this->name,$this->name,$this,$this->settings);
           $controller->populateSettings();
           $controller->postProcess();
           $this->controller[] =  $controller;
    }
    public function buildWidgets(){
        $this->widgeter = new \dynamicformssystem\Widget_Widgeter();
//        $this->widgeter->processWidgets($this->settings);
    }

    public function buildConfigs(){
        $model = new \dynamicformssystem\config($this->name,$this->name,$this,$this->settings);
        $model->populateSettings($this->settings);
        $data = \Input::post();
        print_r($data);die();
        $model->compileConfig();
    }

    public function buildModels(){
        $model = new \dynamicformssystem\model();
        $model->populateSettings($this->settings);
        $model->assignWidgeter($this->widgeter);
        $model->postProcess();
        $this->model = $model;
    }

    public function buildViews(){
        $view = new \dynamicformssystem\view($this->name, $this->name, $this, $this->settings);
        $view->flushFiles();
        $this->model = $view;
       //move this to controller since view is child of controller

    }


    public function getModulePath(){
      return $this->basepath;
    }

    public function createFolders($path){
      $foldersArray = array(
              0=>array("basepath"=>$this->getModulePath(),"dir"=> $this->name ),
              1=>array("basepath"=>$this->getModulePath().DS.$this->name,"dir"=> "classes" ),
              2=>array("basepath"=>$this->getModulePath().DS.$this->name.DS."classes","dir"=> "controller" ),
              4=>array("basepath"=>$this->getModulePath().DS.$this->name.DS."classes","dir"=> "model" ),
              5=>array("basepath"=>$this->getModulePath().DS.$this->name,"dir"=> "config" ),
              6=>array("basepath"=>$this->getModulePath().DS.$this->name,"dir"=> "views" ),
              7=>array("basepath"=>$this->getModulePath().DS.$this->name.DS."views","dir"=> $this->name ),
              8=>array("basepath"=>$this->getModulePath().DS.$this->name.DS."views","dir"=> "base" )
      );
      foreach($foldersArray as $folder){
                  if(!file_exists($folder["basepath"].DS.$folder["dir"]))
                  \File::create_dir($folder["basepath"] , $folder["dir"],0755);
      }
    }

    function preProcess(){
        $path =  $this->getModulePath();
        $this->createFolders($path);
        $this->namespace = $this->name;
        //Assign NameSpace
        //Create subfolders
    }

    function process(){
        $this->buildControllers();
        $this->buildWidgets();
        $this->buildConfigs();
        $this->buildViews();
       // echo "Killed by me {$this->name}";
       // die();

    }




    public function buildFiles(){

    }

    public function flushFiles(){


    }

    public function populateSettings(){

    }

}