<?php 

namespace dynamicformssystem;

class Widget_Hr extends Widget_Base{


        public function __construct($options){
                if(is_array($options)){
                        foreach($options as $key=>$option)
                                $this->$key = $option;
                }

                $this->name="hr".strtotime("now");
                $this->number = $this->name;
                $this->label = $this->name;
        }


        public function render() {

        }

        public function renderBottom(){

        }

        public function renderOnEdit(){

        }
        public function renderOnSign(){
            
        }
}