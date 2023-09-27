<?php 

namespace dynamicformssystem;


class Widget_Widgeter{

    var  $widgets = array(
        'radio-group','checkbox-group','canvas',
        'editabletext', 'date','select','file','textarea' ,
        'hidden' ,"text", "default");



    public function buildWidgetObject($widget){
            $widgetObject = null;
            if(key_exists("hr",$widget) && $widget['hr']==1) $widget['type'] = "hr";
           
            $type = ucwords($widget['type']);
            $widgetSelector = "Widget_$type"; 
            $widgetSelector= str_replace("-","",$widgetSelector);
            $localClass = "\dynamicformssystem\\$widgetSelector";
            
            if(class_exists($localClass)) return  new $localClass($widget);
            else echo "$widgetSelector";  //create widget 
    }
 //remove this method since not needed 
    public function attachToRightArray($widget,$count,$widgetObject){
                if($widget["section" ] !=="__select__"){
                    if(key_exists($widget["section"],$this->sections)) 
                        $this->sections[$widget["section"]]->addWidget($count,$widgetObject);
                    else {

                        $this->delayed_sections[$widget["section"]][$count] = $widgetObject; 
                    }
                        
                }else 
                    $this->widgetObjects[$count] = $widgetObject; 

                if($widget["type" ] =="section")
                $this->sections[$widget['name']] = $widgetObject;
    }
    //remove this method since not needed 
    public function moveToRightArrayFromDelayedArray($count,$widgetObject,$section_name){
        if(key_exists($section_name,$this->sections)) 
        { 
                $this->sections[$section_name]->addWidget($count,$widgetObject);
        }
       unset($this->delayed_sections[$section_name][$count]);
    }

// Rename to create Model here;
    public function processWidgets($widgets){
        $count = 0;
        foreach($widgets['fields'] as $widget){
            if(count(array_keys($widget))<1 || (key_exists("section",$widget) && $widget['section'] !== "__select__") ) {
               // print_r($widget);
                $count++; continue;
            }
            $widgetObject = $this->buildWidgetObject($widget);
            
            if(!is_object($widgetObject)) {
                continue;
            }
            if($widgetObject->type=="section") $widgetObject->addFieldsToProcess($widgets);
            if(is_object($widgetObject))  $this->widgetObjects[$count] = $widgetObject; 
            $count++;   
        }
      $this->buildProperties();
    }

    // property building really not needed for sure

    public function buildProperties(){
        
        $properties = array();
        $submodels = array();


        foreach($this->widgetObjects as $key=>$widgetObject){
            
            if($widgetObject->type !== "section") 
             $properties[$widgetObject->name] = $widgetObject->renderProperties();
            

            if($widgetObject->type == "section")
                {
                    $props = $widgetObject->getSectionProperties();

                    foreach($props as $key=>$prop)  $properties[$key] = $prop;
                    //merge props here only from this section which are fixed , no need to go down the hatches
                    $submodels[] = $widgetObject->getSectionModels();
                    //take models from the bottom to be kept here , each section will carry its own models
                    //So this is self explanatory.
                }

        }
    //    $properties["check"] = $submodels;

       print_r($properties);
    }

    public function testDump(){



     //   print_r($this->widgetObjects);
    //    print_r($this->sections);
      //  print_r($this->delayed_sections);
        die();

    }
    var $sections = array();
    var $widgetObjects= array(); 
    var $delayed_sections = array();

}