<?php 

namespace dynamicformssystem;

class Widget_Section extends Widget_Base{

      var $widgetObjects= array(); 
      var $delayed_sections = array();

        public function __construct($options){
          if(is_array($options)){
                  foreach($options as $key=>$option)
                          $this->$key = $option;
          }
          $this->number = strtotime("now");
        }

        public function render() {

        }

        public function renderBottom(){

        }


        public function renderProperties(){
          $modelSet = array();
          $models = array();
  
          foreach($this->widgetObjects as $widgetObject){
  
              if($widgetObject->type !== "section") $models[$widgetObject->name] = $widgetObject->renderProperties();
              if($widgetObject->type == "section" && $widgetObject->sectionType == 2 ){
                 // $multiModels =  $widgetObject->renderProperties();
                 // foreach($multiModels as $key =>$model) $modelSet[$key] = $model;
                 $modelSet[$widgetObject->name] = $widgetObject->renderProperties();
              }else{
                  foreach($widgetObject->renderProperties() as $key=>$widget) $models[$key] = $widget;
                  
              }
  
          }

          $modelSet["main"] = $models;
          die();
      }

     

        public function addFieldsToProcess($widgets){
          $count = 0;
          foreach($widgets['fields'] as $widget){
            if(
                count(array_keys($widget))<1  
                || (key_exists("section",$widget) && $widget['section'] == "__select__")  
                || (key_exists("section",$widget) && $widget['section'] !== $this->name)  
                || (key_exists('name',$widget) && $widget['name'] ==  $this->name )
            )
             {
             //  print_r($widget);
              $count++;
              continue;
            }
            $widgetObject = $this->buildWidgetObject($widget);
            try{
              $widgetObject->parent=$this->name;

            }catch(\Fuel\Core\PhpErrorException $e){
                echo "see here below</br>section";
                print_r($widget);die();

            }
            
            $widgetObject->parent2=$this->name;
            if($widgetObject->type=="section" ) {
              $widgetObject->addFieldsToProcess($widgets);

            }
            $this->widgetObjects[$count] = $widgetObject; 
            $count++;
          }
         

        }

        public function renderOnEdit(){

        }

        public function getSectionProperties(){
          $models =array();
          if($this->sectionType ==2){

          }else {

            foreach($this->widgetObjects as $widgetObject){  
             
              if($widgetObject->type !== "section") {
                  $models[$widgetObject->name] = $widgetObject->renderProperties();
                  
                }
            }
          }
          
          return $models;
        }

        public function getSectionModels(){
          $models =array();
        //  $models ["hasmany"] = array();
          $models["one"] = array();
          foreach($this->widgetObjects as $widgetObject){
            if($widgetObject->type == "section")
          {
//$widgetObject->sectionType=="2")

          }else {

            $models["one"] = $this->getSectionProperties();




          }


          }

          return $models;
        }
        public function renderOnSign(){
          
        }
        public function addWidget($count,$widget){
                  
                    $this->widgetObjects[$count] =$widget;
        }
}