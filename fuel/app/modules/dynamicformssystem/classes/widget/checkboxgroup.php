<?php 

namespace dynamicformssystem;

class Widget_Checkboxgroup extends Widget_Base{

      var $type="checkboxgroup";
      var $options = array();
      var $lang = array();


     


      public function render(){


        foreach($this->$options as $option){

            $string = "\Lang::get('{$option['label']}')?\Lang::get('{$option['label']}'):'{$option['label']}'";


        }

        // Take subset of values , 
        // Render values for create ( as in no need to look for posted data here)
        // Render values for lang 
        



      }




}